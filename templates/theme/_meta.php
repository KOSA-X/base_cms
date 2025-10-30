<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;  
?>
<!DOCTYPE HTML>
<html lang="<?php echo $config['language']; ?>">
<head>
    <meta charset="utf-8" /> 
    <title><?php echo $config['title']; ?></title>
    <meta name="description" content="<?php echo $config['description']; ?>" />
    <meta name="generator" content="Quick.Cms v<?php echo $config['version']; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link id="favicon" rel="shortcut icon" type="image/x-icon" href="<?php echo FAVICON; ?>">
    <link rel="apple-touch-icon" href="<?php echo FAVICON; ?>">
    <link rel="canonical" href="<?php echo CURRENT_URL; ?>">
    <meta name="author" content="kosa-x.com - digital marketing">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="sitemap.xml" />
    <meta name="theme-color" content="#000">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.41/dist/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="<?php echo THEME; ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo THEME; ?>js/scrollReveal.min.js"></script>
    <script src="<?php echo $js_file; ?>"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="<?php echo $css_file; ?>" media="all"/>
    <meta property="og:title" content="<?php echo $config['title']; ?>">
    <meta name="twitter:title" content="<?php echo $config['title']; ?>" />
    <meta property="og:description" content="<?php echo $page_desc; ?>">
    <meta name="twitter:description" content="<?php echo $page_desc; ?>">
    <meta property="og:url" content="<?php echo CURRENT_URL; ?>">
    <meta property="og:image" content="<?php echo $image_for_facebook; ?>">
    <meta name="twitter:image" content="<?php echo $image_for_facebook; ?>">
    <meta property="og:image:secure_url" content="<?php echo $image_for_facebook; ?>">
    <meta property="og:site_name" content="<?php echo $config['logo']; ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pl_PL" />
    <base href="<?php echo BASE_URL; ?>">
    <?php if($config['google-site-verification'] != ""){ ?>
    <meta name="google-site-verification" content="<?php echo $config['google-site-verification']; ?>" />
    <?php }?>
<?php if($config['tagmenager'] != ""){ ?><!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo $config['tagmenager']; ?>');</script>
    <!-- End Google Tag Manager --><?php }?>
<?php if($config['analytics'] != ""){ ?><!-- Google Tag Manager -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $config['analytics']; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo $config['analytics']; ?>');
    </script><?php }?>
</head>
<body<?php echo $config['body_id_class_name']; ?>>
<?php if($config['tagmenager'] != ""){ ?><!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $config['tagmenager']; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php }?>
