<?php


// LINKOWANIE
//$base_url = "https://avit.pl";
//$actual_url = $base_url.$_SERVER['REQUEST_URI'];


$header_class = "mainHeader";



define('BASE_URL', 'https://kosa-x.com/www/nec-diagnostics.pl');
define('CURRENT_URL', BASE_URL.$_SERVER['REQUEST_URI']);
define('IMAGES', BASE_URL."/images/");
define('FILES', BASE_URL."/files/");
define('ICONS', IMAGES."icons/");
define('SHOP_PAGE', $config['current_page_id'] == $config['shop_page'] ? TRUE : FALSE);
define('THEME', BASE_URL."/templates/".$config['skin']."/");
define('LOGO_URL', IMAGES."logo.svg?ver=".(filemtime("./images/logo.svg")));



$logo = '<img src="'.LOGO_URL.'" alt="'.$config['logo'].'" class="logo_img logo_light"><img src="'.IMAGES.'logo-dark.svg" alt="'.$config['logo'].'" class="logo_img logo_dark">';

define('LOGO', $logo);
define('FAVICON', IMAGES."favicon.webp");





$css_file = THEME."css/style.css?ver=".filemtime("./templates/".$config['skin']."/css/style.css");
$js_file = THEME."js/scripts.js?ver=".filemtime("./templates/".$config['skin']."/js/scripts.js");


$page_desc = $config['description'];
$image_for_facebook = IMAGES."default-image.png";



// licznik wyświetleń strony
function update_views($page_id){
    $oSql = Sql::getInstance( );
    $set_views = $oSql->getQuery( 'UPDATE pages SET sViews=sViews+1  WHERE iPage="'.$page_id.'" ' );
}


// skracanie stringa $string, ilość słow
function trunc($phrase, $max_words) {
   $phrase_array = explode(' ',$phrase);
   if(count($phrase_array) > $max_words && $max_words > 0)
      $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
   return strip_tags($phrase);
}



// ilość zdjęć 
function image_count($id){
    $oSql = Sql::getInstance( );
    $photo_array = $oSql->getQuery( 'SELECT * FROM files WHERE iPage="'.$id.'" AND iType="1"');
    $i = 0;
    while( $photo = $photo_array->fetch( PDO::FETCH_ASSOC ) ){
        $i++;
    }
    return $i;
}

function getUrl($id){
    $oPage = Pages::getInstance();
    return $oPage->aPages[$id]['sLinkName'];
}



function getData($id, $name, $type = 'pages'){
	$oSql = Sql::getInstance( );
    
    $oQuery = $oSql->getQuery('SELECT iPage, '.$name.' FROM '.$type.' 
    WHERE iPage="'.$id.'"
    '.($type == 'files' ? 'AND iSize > 0  AND iDefault = "1" ' : '').' LIMIT 1');
    
    $getData = $oQuery->fetch(PDO::FETCH_ASSOC);
    
    if($getData[$name] != ""){
        return $getData[$name];
    } else {
        return FALSE;
    }
}

function parametrs($data, $options){
        $parametrs = "";
        $counterParametrs = 0;
        $counterWhile = 0;
        $contentParametrs = "";
        $string = str_replace(' ', '', $data);
        $parametrs = explode("|", $string);
        $counterParametrs = count($parametrs);
        if($counterParametrs > 0){
            while($counterWhile < $counterParametrs){
                if($parametrs[$counterWhile]){
                $contentParametrs .= "<li>".$parametrs[$counterWhile]."</li>";
//                $contentParametrs .= "<li><a href='szukaj/?tag=".$parametrs[$counterWhile]."'>".$parametrs[$counterWhile]."</a></li>";
                    }
                $counterWhile++;
            }
            return '<ul class="parametrs__list '.($options['class']).'">'.$contentParametrs.'</ul>';
        }
}


function icon($file){
    return $base_url."images/icons/".$file;
}
function image($file){
    return $base_url."images/".$file;
}

function cartIcon(){
    global $config, $oPage;
    $content = "";
    $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
    $total_items = array_sum($cart);
    $count = $total_items > 0 ? " <span class='count'>".$total_items."</span>" : "";
    $content .= TRUE ? '<a href="'.($oPage->aPages[$config['cart_page']]['sLinkName']).'"><img src="'.ICONS.'cart.svg" alt="Koszyk" class="icon invert"><span class="label">Koszyk</span></a>' : "";

    if($content != ""){
        return '<div class="cartIcon">'.$content.$count.'</div>';
    }
}

function orderProducts($data){
    $content = "";
    if (is_string($data)) {
        $data = str_replace("'", '"', $data); // Zamiana pojedynczych cudzysłowów na podwójne
        $data = json_decode($data, true); // Dekodowanie JSON-a do tablicy asocjacyjnej
    }
    if (!is_array($data) || empty($data)) {
        return "<p>Brak produktów</p>";
    }
    if (!empty($data)) {
        $content .= '<ul class="products">';
        foreach ($data as $product_id => $quantity) {
            $name = getData($product_id, 'sName');
            $price_item = getData($product_id, 'sPrice') * $quantity;
            $content .= '<li>';
            $content .= '<strong style="margin-right:10px" class="name">'.$name.'</strong> ';
            $content .= ' <span class="price">'.$quantity.' x '.$price_item.' zł</span>';
            $content .= '</li>';
        }
        $content .= "</ul>";
        return $content;   
    }
}


function listElements(array $categories, array $options = []) {
    $limit = (int)($options['limit'] ?? 0);
    $url   = rtrim($options['url'] ?? '', '/');

    $html = "<ul class='listElements'>\n";
    $count = 0;
    
    $html .= "<li class=\"listElements__item item_all\"><a href=\"$url#category-all\">Wszystkie</a></li>\n";

    foreach ($categories as $id => $name) {
        if ($id == 0) continue;
        if ($limit && $count++ >= $limit) break;

        $idEsc = htmlspecialchars($id);
        $text  = htmlspecialchars($name);
        $link  = "<a href=\"$url#category-$idEsc\">$text</a>";

        $html .= "<li class=\"listElements__item item_$idEsc\" data-id=\"$idEsc\">$link</li>\n";
    }

    return $html . "</ul>";
}


function getElement($id, array $categories) {
    return $categories[$id] ?? null;
}

 

 

function orderPayment($data){
    switch($data){
        case 1:
            return "Płatność przelewem na konto";
            break;
        case 2:
            return "Płatność payU";
            break;
    }
}

function orderDelivery($data){
    switch($data){
        case 1:
            return "Dostawa Kurierem DPD (20zł)";
            break;
        case 2:
            return "Dostawa do Paczkomatu Inpost (15zł)";
            break;
    }
}

function orderStatus($data){
    switch($data){
        case 0:
            return "Nowe";
            break;
        case 1:
            return "Wysłano paczkę";
            break;
    }
}

function project_category($data){
    switch($data){
        case 0:
            return "Brak";
            break;
        case 1:
            return "Mieszkaniowe";
            break;
        case 2:
            return "Przemysłowe";
            break;
        case 3:
            return "Użyteczności publicznej";
            break;
        case 4:
            return "Inne";
            break;
    }
}


function listMenu($options){
    $oSql = Sql::getInstance();
    $oPage = Pages::getInstance();
//    $oFile = Files::getInstance();
    global $config;
    $content = "";
//    $gallery = "";
//     '.sql().' 
    
    $result = $oSql->getQuery( 'SELECT * FROM pages WHERE iStatus > 0 
    '.(isset($options['sql']) && $options['sql'] != "" ? "AND ".$options['sql'] : '').'
    ORDER BY '.(isset($options['random']) && $options['random'] == TRUE ? ' RANDOM() ' : 'iPosition DESC, iPage DESC').'
    '.(isset($options['limit']) && $options['limit'] != "" ? 'LIMIT '.$options['limit'] : '').'
    
    ');
  
    $class .= (isset($options['class']) != "" ? " ".$options['class'] : "");   
    $class .= (isset($options['toggle']) && $options['toggle'] == TRUE ? " widget-toggle" : "");   
 
    $no_data = TRUE;
    $content .= "<aside class='widget".$class."'>".( isset( $options['title'] ) ? '<h4 class="widget__title">'.$options['title'].( isset( $options['toggle'] ) ? '<span class="widget__arrow"><img src="'.ICONS.'arrow.svg" alt="Strzałka"></span>' : null ).'</h4>' : null ).'<div class="widget__wrapper"><ul class="widget__list">';
    while( $data = $result->fetch( PDO::FETCH_ASSOC ) ){
        $no_data = FALSE;
        $content .= '<li><a href="'.$oPage->aPages[$data['iPage']]['sLinkName'].'" class="widget__link'.(isset($config['current_page_id']) && $config['current_page_id'] == $data['iPage'] ? ' selected' : null).'">'.$data['sName'].'</a></li>';
     }
    $content .= "</ul>";
    $content .= isset($options['footer']) && $options['footer'] != "" ? "<footer class='widget__footer'>".$options['footer']."</footer>" : "";
    
    
    $content .= "</div>";
    $content .= "</aside>";
    
    if($no_data){
//        $content .= "<p>Brak wyników</p>";
    }
    echo $content;
    
}

function listPages($options){
    $oSql = Sql::getInstance();
    $oPage = Pages::getInstance();
    global $config;
    $content = "";
//     '.sql().' 
    
    $result = $oSql->getQuery( 'SELECT * FROM pages WHERE iStatus > 0 
    '.(isset($options['sql']) && $options['sql'] != "" ? "AND ".$options['sql'] : '').'
    ORDER BY '.(isset($options['random']) && $options['random'] == TRUE ? ' RANDOM() ' : 'iPosition DESC, iPage DESC').'
    '.(isset($options['limit']) && $options['limit'] != "" ? 'LIMIT '.$options['limit'] : '').'
    
    ');
  
    $class .= (isset($options['class']) != "" ? " ".$options['class'] : "");   
    $class .= (isset($options['toggle']) && $options['toggle'] == TRUE ? " widget-toggle" : "");   
    $content .= "<ul class='pagesList".$class."'>";
    while( $data = $result->fetch( PDO::FETCH_ASSOC ) ){
        $data['sLinkName'] = $oPage->aPages[$data['iPage']]['sLinkName'];
         $content .= listPagesView( $data, $options );
     }
    $content .= "</ul>";
 
    echo $content;
    
}
              



function sendEmail($data){
    global $config;
    
    $alert = isset($data['alert']) ? $data['alert'] : TRUE;
    
    $email = isset($data['email']) ? $data['email'] : $config['email'];
    $from = isset($data['from']) ? $data['from'] : $config['email'];
    $subject = isset($data['subject']) ? $data['subject'] : "Kontakt - ".$config['logo'];
    $message = isset($data['message']) ? $data['message'] : "";
    $replyTo = $config['logo'].' <'.$from.'>';

    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-Type: text/html; charset=utf-8'."\r\n";
    $headers .= 'From: "'.$config['logo'].'" <'.$from.'>'."\r\n";
    $headers .= 'Reply-To: '.$from."\r\n";
    $additional_parameters = "-f ".$config['email'];



    if (mail($email, $subject, $message, $headers, $additional_parameters)) {
        echo $alert ? '<div class="alert alert-success">'.$data['alert'].'</div>' : '';
    } else {
        echo $alert ? '<div class="alert alert-danger">Nie wysłano wiadomości.</div>' : '';
    }


}

function contacts($options = ""){
    global $config;
    $content = "";
    $phone = isset($options['phone']) && $options['phone'] == TRUE ? TRUE : FALSE;
    $email = isset($options['email']) && $options['email'] == TRUE ? TRUE : FALSE;
    $location = isset($options['location']) && $options['location'] == TRUE ? TRUE : FALSE;
    $hours = isset($options['hours']) && $options['hours'] == TRUE ? TRUE : FALSE;
 
    
 
    $content .= $phone && $config['phone'] != "" ? '<li class="phone"><span class="label">Telefon</span><a href="tel:'.$config['phone'].'" class="value phone1"><img src="'.ICONS.'phone-line.svg" alt="Phone" class="invert">'.$config['phone'].'</a>'.($config['phone2'] != "" ? '<a href="tel:'.$config['phone2'].'" class="value phone2">'.$config['phone2'].'</a>' : '').'</li>' : "";
    $content .= $email && $config['email'] != "" ? '<li class="email"><span class="label">E-mail</span><a href="mailto:'.$config['email'].'" class="value"><img src="'.ICONS.'email-line.svg" alt="Email" class="invert">'.$config['email'].'</a></li>' : "";
    
    $content .= $location && $config['city'] != "" ? '<li class="location"><span class="label">Biuro</span><a href="'.$config['maps'].'" target="_blank" class="value"><img src="'.ICONS.'location-line.svg" alt="Location" class="invert">'.($config['street'] ? $config['street'].", " : "").($config['city'] ? $config['city'] : "").'</a>'.($hours ? hoursOpen() : "").'</li>' : "";

    if($content != ""){
        return '<ul class="contactsList">'.$content.'</ul>';
    }
}

function contactsButtons(){
    global $config, $lang;
    $content = "";
    $content .= $config['phone'] != '' ? '<li class="contactButtons__item phone"><a href="tel:'.$config['phone'].'" class="button"><img src="'.ICONS.'phone-line.svg" alt="'.$lang['call'].'" title="'.$lang['call'].'" class="icon">'.$lang['call'].'</a></li>' : '';
    $content .= $config['email'] != '' ? '<li class="contactButtons__item email"><a href="mailto:'.$config['email'].'" class="button"><img src="'.ICONS.'email-line.svg" alt="'.$lang['email_me'].'" title="'.$lang['email_me'].'" class="icon">'.$lang['email_me'].'</a></li>' : '';
    
    if($content != ""){
        return '<ul class="contactButtons">'.$content.'</ul>';
    }
}

function socialMedia($options = ""){
    global $config;
    $content = "";
    
    if(isset($options['contacts']) && $options['contacts'] == TRUE){
        $content .= $config['phone'] != '' ? '<li class="phone"><a href="tel:'.$config['phone'].'"><span class="icon"><img src="'.ICONS.'phone.svg" alt="'.$lang['call'].'" title="'.$lang['call'].'" class="invert"></span><span class="label">'.$lang['call'].'</span></a></li>' : '';
        $content .= $config['email'] != '' ? '<li class="email"><a href="mailto:'.$config['email'].'"><span class="icon"><img src="'.ICONS.'email.svg" alt="'.$lang['email_me'].'" title="'.$lang['email_me'].'" class="invert"></span><span class="label">'.$lang['email_me'].'</span></a></li>' : '';
    }
    
    $content .= $config['facebook'] != "" ? '<li class="facebook"><a href="'.$config['facebook'].'" target="_blank"><span class="icon"><img src="'.ICONS.'facebook.svg" alt="Facebook" class="invert"></span><span class="label">Facebook</span></a></li>' : "";
    $content .= $config['linkedin'] != "" ? '<li class="linkedin"><a href="'.$config['linkedin'].'" target="_blank"><span class="icon"><img src="'.ICONS.'linkedin.svg" alt="LinkedIn" class="invert"></span><span class="label">LinkedIn</span></a></li>' : "";
    $content .= $config['instagram'] != "" ? '<li class="instagram"><a href="'.$config['instagram'].'" target="_blank"><span class="icon"><img src="'.ICONS.'instagram.svg" alt="Instagram" class="invert"></span><span class="label">Instagram</span></a></li>' : "";
    //$socialMediaList .= $config['messenger'] != "" ? '<li class="messenger"><a href="'.$config['messenger'].'" target="_blank"><span class="icon"><img src="images/icons/messenger.svg" alt="Messenger"></span><span class="label">Messenger</span></a></li>' : "";
    $content .= $config['youtube'] != "" ? '<li class="youtube"><a href="'.$config['youtube'].'" target="_blank"><span class="icon"><img src="'.ICONS.'youtube.svg" alt="Youtube" class="invert"></span><span class="label">Youtube</span></a></li>' : "";
    $content .= $config['tiktok'] != "" ? '<li class="tiktok"><a href="'.$config['tiktok'].'" target="_blank"><span class="icon"><img src="'.ICONS.'tiktok.svg" alt="TikTok" class="invert"></span><span class="label">TikTok</span></a></li>' : "";
    $content .= $config['twitter'] != "" ? '<li class="twitter"><a href="'.$config['twitter'].'" target="_blank"><span class="icon"><img src="'.ICONS.'twitter.svg" alt="Twitter" class="invert"></span><span class="label">Twitter</span></a></li>' : "";
    if($content != ""){
        return '<ul class="socialMediaIcons">'.$content.'</ul>';
    }
}

function language(){
    global $config;
    return '<div class="chooseLanguage lang-select chooseLanguage-'.$config['language'].'">
               <div id="google_translate_element"></div>
                  <div class="chooseLanguage__button lang-selected" data-val="'.$config['language'].'" translate="no"><img src="'.ICONS.'flag-'.$config['language'].'.png" class="chooseLanguage__button_flag" alt="Language '.$config['language'].'"><span class="chooseLanguage__button_arrow"></span></div>
                   <ul class="chooseLanguage__list lang-select-list">
                       <li class="language-item language-item-pl lang-select-item" data-val="pl" translate="no"><img src="'.ICONS.'flag-pl.png" alt="Language PL">Polish</li>
                       <li class="language-item language-item-en lang-select-item" data-val="en" translate="no"><img src="'.ICONS.'flag-en.png" alt="Language GB">English</li>
                       <li class="language-item language-item-de lang-select-item" data-val="de" translate="no"><img src="'.ICONS.'flag-de.png" alt="Language DE">German</li>
                   </ul>
               </div>'; 
}

function darkMode(){
    return '<div class="darkMode form-switch theme-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="theme-switch-checkbox">
              <label class="form-check-label" for="theme-switch-checkbox"><img src="'.ICONS.'night.svg" alt="Ciemny motyw" class="invertImg"></label>
              <span class="label">Ciemny motyw</span>
            </div>'; 
}

function location(){
    global $config;
    return $config['city'] != "" ? '<div class="location"><img src="images/icons/location.svg">'.($config['street'] ? $config['street'].", " : "").($config['city'] ? $config['city'] : "").'</div>' : ""; 
}


function hoursOpen($show = TRUE){
    global $config;
    $dni_tygodnia = date( "N" );
    $aktualna_godzina = date( "H,i" );
    $content = "";
    //$aktualna_godzina = "02,00";
    // Co mamy dzisiaj za dzień i do której są zmówienia
    $start_tydz = isset($config['hours_1']) ? str_replace(':', ',', $config['hours_1']) : "";
    $end_tydz = isset($config['hours_2']) ? str_replace(':', ',', $config['hours_2']) : "";
    $start_sob = isset($config['hours_3']) ? str_replace(':', ',', $config['hours_3']) : "";
    $end_sob = isset($config['hours_4']) ? str_replace(':', ',', $config['hours_4']) : "";
    $start_ndz = isset($config['hours_5']) ? str_replace(':', ',', $config['hours_5']) : "";
    $end_ndz = isset($config['hours_6']) ? str_replace(':', ',', $config['hours_6']) : "";
    $content .= "<div class='hoursOpen'>";
    
    if($show){
        $content .= "<div class='hoursOpen__title'><img src='".ICONS."time.svg' alt='Godziny otwarcia' class='invert'>Godziny otwarcia</div>";
        $content .= "<ul class='hoursOpen__list'>";
        $content .= isset($config['hours_1']) && $config['hours_1'] != "" && isset($config['hours_2']) ? "<li>Poniedziałek - piątek: <strong>".$config['hours_1']." - ".$config['hours_2']."</strong></li>" : "";
        $content .= isset($config['hours_3']) && $config['hours_3'] != "" && isset($config['hours_4']) ? "<li>Sobota: <strong>".$config['hours_3']." - ".$config['hours_4']."</strong></li>" : "";
        $content .= isset($config['hours_5']) && $config['hours_5'] != "" && isset($config['hours_6']) ? "<li>Niedziela: <strong>".$config['hours_5']." - ".$config['hours_6']."</strong></li>" : "";
        $content .= "</ul>";
    }
    
    if(($dni_tygodnia >= "1") && ($dni_tygodnia <= "5")){
        // PONIEDZIAŁEK - PIĄTEK
        // od 00:00 do otawrcia rano
       if($aktualna_godzina > $start_tydz && $aktualna_godzina < $end_tydz){
            $hoursOpen = '<span class="hoursOpen__open"></span>Biuro obecnie jest <strong>otwarte</strong> i będzie czynne do godz. '.$config['hours_2'].'.';
        }else{
            // zamknięte, czas po godzinie zamknięcia ~16:00
            $hoursOpen = '<span class="hoursOpen__close"></span>Biuro obecnie jest <strong>nieczynne</strong>.';
        }
    }elseif($dni_tygodnia == 6 && $start_sob != "" && $end_sob != "" ){
        // SOBOTA
        if($aktualna_godzina > $start_sob && $aktualna_godzina < $end_sob){
            $hoursOpen = '<span class="hoursOpen__open"></span>Biuro obecnie jest <strong>otwarte</strong> i będzie czynne do godz. '.$config['hours_4'].'.';
        }else{
            // zamknięte, czas po godzinie zamknięcia ~16:00
            $hoursOpen = '<span class="hoursOpen__close"></span>Biuro obecnie jest <strong>nieczynne</strong>.';
        }
    }elseif($dni_tygodnia == 7 && $start_ndz != "" && $end_ndz != "" ){
        // NIEDZIELA
        if($aktualna_godzina > $start_ndz && $aktualna_godzina < $end_ndz){
            $hoursOpen = '<span class="hoursOpen__open"></span>Biuro obecnie jest <strong>otwarte</strong> i będzie czynne do godz. '.$config['hours_6'].'.';
        }else{
            // zamknięte, czas po godzinie zamknięcia ~16:00
            $hoursOpen = '<span class="hoursOpen__close"></span>Biuro obecnie jest <strong>nieczynne</strong>.';
        }
    }else{
        $hoursOpen = '<span class="hoursOpen__close"></span>Biuro obecnie jest <strong>nieczynne</strong>.';
    }
    $content .= '<div class="hoursOpen__desc">'.$hoursOpen.'</div>';
    $content .= "</div>";
    
    return $content;
}



if( isset( $aData['sName'] ) ){
    
    // WYŚWIETLENIA
    update_views($aData['iPage']);
    
    if(getData($aData['iPage'], "sDescriptionShort") != ""){
        $page_desc = substr(strip_tags(getData($aData['iPage'], "sDescriptionShort")), 0, 150);
    }elseif(getData($aData['iPage'], "sDescriptionFull") != ""){
        $page_desc = substr(strip_tags(getData($aData['iPage'], "sDescriptionFull")), 0, 150);
    }

    if(($oFile->metaFacebook( $aData['iPage'], 1 )) != ""){
        $image_for_facebook = $base_url."/files/".$oFile->metaFacebook( $aData['iPage'], 1 );
    } 
}

// KONTAKTY
//$contactsList = contactsList();
//$socialMediaList = socialMediaList();

