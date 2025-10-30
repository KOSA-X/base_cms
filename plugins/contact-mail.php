<?php
// =====================
// KONFIGURACJA
// =====================
 
    
$settings = [
    // gdzie ma przyjść mail
    'email_to'      => 'k@kosiorski.pl',
    'email_to_name' => 'Biuro X',

    // dane nadawcy technicznego (konto SMTP)
    'smtp_host'     => 'mail.kosa-x.com',
    'smtp_user'     => 'k@kosa-x.com',
    'smtp_pass'     => '#Pr0tect21',
    'smtp_port'     => 587,
    'smtp_secure'   => 'tls', // 'tls' albo 'ssl'

    // nazwa strony / projektu
    'site_name'     => 'Moja strona',

    // reCAPTCHA v3
    'recaptcha_site_key'   => $config['publicKey'], // do <script> w HTML
    'recaptcha_secret_key' => $config['secretKey'], // do weryfikacji w PHP

    // upload
    'upload_allowed_ext' => ['pdf','jpg','jpeg','png','doc','docx','xls','xlsx'],
    'upload_max_size'    => 2 * 1024 * 1024, // 2 MB
];

// =====================
// POMOCNICZE
// =====================
function show_form($msg = '', $old = [], $settings = [])
{
    global $config;
    // wartości po nieudanym submitcie
    $name    = isset($old['name']) ? htmlspecialchars($old['name']) : '';
//    $phone   = isset($old['phone']) ? htmlspecialchars($old['phone']) : '';
    $email   = isset($old['email']) ? htmlspecialchars($old['email']) : '';
    $message = isset($old['message']) ? htmlspecialchars($old['message']) : '';

    // ważne: reCAPTCHA v3 działa po stronie frontu – tu wstrzykniemy site_key
    $siteKey = $settings['recaptcha_site_key'] ?? '';

    echo $msg;
    ?>
    <form action="" method="post" class="form pageContact__form" enctype="multipart/form-data">
        

        <div class="row">
            <div class="col-6">
                <div class="form-floating form-item">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="Imię i nazwisko" required>
                    <label for="name">Imię i nazwisko <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating form-item">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="Adres e-mail" required>
                    <label for="email">E-mail <span class="text-danger">*</span></label>
                </div>
            </div>
        </div>

        <div class="form-floating form-item">
            <textarea name="message" class="form-control" rows="4" id="message"  placeholder="Message"><?php echo $message; ?></textarea>
            <label for="message" class="col-form-label">Treść wiadomości</label>
        </div>

        <!-- ZAŁĄCZNIK -->
        <div class="form-item mb-3">
            <label for="attachment" class="form-label">Załącz plik (opcjonalnie)</label>
            <input type="file" name="attachment" id="attachment" class="form-file">
            <small class="text-muted form-text">Dozwolone: <?php echo implode(', ', $settings['upload_allowed_ext']); ?>. Maks: <?php echo (int)($settings['upload_max_size']/1024/1024); ?> MB</small>
        </div>

        <div class="form-check form-item mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="regulamin" name="regulamin" required>
            <label class="form-check-label" for="regulamin">
                <span class="text-danger">*</span>  Akceptuję warunki zawarte w <a href="<?php echo getUrl($config['private_policy']); ?>" class="link_underline" target="_blank"><?php echo getData($config['private_policy'], 'sName'); ?></a>. 
            </label>
        </div>

        <!-- reCAPTCHA v3 -->
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
        <input type="hidden" name="action" value="contact_form">

        <div class="form-button">
            <button type="submit" id="submit" name="submit" class="button">Wyślij</button>
        </div>
    </form>

    <?php if ($siteKey): ?>
        <!-- reCAPTCHA v3 front -->
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $siteKey; ?>"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo $siteKey; ?>', {action: 'contact_form'}).then(function(token) {
                    var recaptchaResponse = document.getElementById('g-recaptcha-response');
                    recaptchaResponse.value = token;
                });
            });
        </script>
    <?php endif; ?>
    <?php
}

// =====================
// LOGIKA WYSYŁKI
// =====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // zbierz dane
    $name    = trim($_POST['name'] ?? '');
//    $phone   = trim($_POST['phone'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $regulamin = isset($_POST['regulamin']);

    $old = [
        'name' => $name,
//        'phone' => $phone,
        'email' => $email,
        'message' => $message
    ];

    // walidacja podstawowa
    if ($name === '' || $email === '' || !$regulamin) {
        show_form('<div class="alert alert-danger">Uzupełnij wymagane pola.</div>', $old, $settings);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        show_form('<div class="alert alert-danger">Podaj poprawny adres e-mail.</div>', $old, $settings);
        exit;
    }

    // weryfikacja reCAPTCHA v3
    $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
    $recaptchaSecret = $settings['recaptcha_secret_key'];

    if ($recaptchaSecret) {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($verifyUrl . '?secret=' . urlencode($recaptchaSecret) . '&response=' . urlencode($recaptchaToken) . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
        $responseData = json_decode($response, true);

        if (empty($responseData['success']) || ($responseData['score'] ?? 0) < 0.3) {
            show_form('<div class="alert alert-danger">Nie udało się zweryfikować, że nie jesteś robotem.</div>', $old, $settings);
            exit;
        }
    }

    // obsługa załącznika
    $uploadedFilePath = null;
    $uploadedFileName = null;
    if (!empty($_FILES['attachment']['name'])) {
        $fileError = $_FILES['attachment']['error'];
        if ($fileError === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['attachment']['tmp_name'];
            $origName = $_FILES['attachment']['name'];
            $size = $_FILES['attachment']['size'];

            // rozszerzenie
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            if (!in_array($ext, $settings['upload_allowed_ext'])) {
                show_form('<div class="alert alert-danger">Ten typ pliku nie jest dozwolony.</div>', $old, $settings);
                exit;
            }

            if ($size > $settings['upload_max_size']) {
                show_form('<div class="alert alert-danger">Plik jest zbyt duży.</div>', $old, $settings);
                exit;
            }

            // możesz przenieść do /tmp albo innego katalogu
            $uploadedFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('att_') . '.' . $ext;
            if (!move_uploaded_file($tmpName, $uploadedFilePath)) {
                show_form('<div class="alert alert-danger">Nie udało się zapisać załącznika.</div>', $old, $settings);
                exit;
            }

            $uploadedFileName = $origName;
        } else {
            show_form('<div class="alert alert-danger">Błąd podczas uploadu pliku.</div>', $old, $settings);
            exit;
        }
    }

    // =====================
    // WYSYŁKA PHPMailer
    // =====================
    // Ścieżki dostosuj do siebie:
    require 'plugins/PHPMailer/src/PHPMailer.php';
    require 'plugins/PHPMailer/src/SMTP.php';
    require 'plugins/PHPMailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // serwer
        $mail->isSMTP();
        $mail->Host       = $settings['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $settings['smtp_user'];
        $mail->Password   = $settings['smtp_pass'];
        $mail->SMTPSecure = $settings['smtp_secure'];
        $mail->Port       = $settings['smtp_port'];
        $mail->CharSet    = 'UTF-8';

        // nadawca (techniczny)
        $mail->setFrom($settings['smtp_user'], $settings['site_name']);

        // odbiorca
        $mail->addAddress($settings['email_to'], $settings['email_to_name']);

        // reply-to – tu ważne: chcemy móc kliknąć "odpowiedz" i mieć klienta
        $mail->addReplyTo($email, $name);

        // załącznik jeśli był
        if ($uploadedFilePath && $uploadedFileName) {
            $mail->addAttachment($uploadedFilePath, $uploadedFileName);
        }

        // treść
        $subject = 'Kontakt ze strony - ' . $settings['site_name'];
        $body  = '<h3>Wiadomość z formularza kontaktowego</h3>';
        $body .= '<p><strong>Imię i nazwisko / firma:</strong> ' . htmlspecialchars($name) . '</p>';
//        $body .= '<p><strong>Telefon:</strong> ' . htmlspecialchars($phone) . '</p>';
        $body .= '<p><strong>E-mail:</strong> ' . htmlspecialchars($email) . '</p>';
        if ($message !== '') {
            $body .= '<p><strong>Wiadomość:</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>';
        }
        $body .= '<hr><small>Wysłane: ' . date('Y-m-d H:i:s') . '</small>';

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        // po wysłaniu usuń plik tymczasowy
        if ($uploadedFilePath && file_exists($uploadedFilePath)) {
            unlink($uploadedFilePath);
        }

        echo '<div class="alert alert-success">Wiadomość została wysłana. Dziękujemy!</div>';
        // pokaż pusty formularz
        show_form('', [], $settings);

    } catch (Exception $e) {
        // po błędzie też warto sprzątnąć
        if ($uploadedFilePath && file_exists($uploadedFilePath)) {
            unlink($uploadedFilePath);
        }

        show_form('<div class="alert alert-danger">Nie udało się wysłać wiadomości. Błąd: '.$mail->ErrorInfo.'</div>', $old, $settings);
    }

} else {
    // pierwszy GET – pokaż formularz
    show_form('', [], $settings);
}
?>
