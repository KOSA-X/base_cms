<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
require_once 'templates/'.$config['skin'].'/_meta.php';
?>
<header class="mainHeader">
   <div class="mainHeader__top">
        <div class="container">
            <?php echo contacts(array('phone' => TRUE, 'email' => TRUE)); ?>
            <?php echo socialMedia(); ?>
            <?php echo language(); ?>
            <?php echo darkMode(); ?>
        </div>
    </div>
    <div class="mainHeader__center">
        <div class="container">
            <div class="mainHeader__logo">
                <a href="<?php echo BASE_URL; ?>">
                  <?php echo LOGO; ?>
                </a>
            </div>
            <?php echo cartIcon(); ?>
            <div class="mainHeader__menu_button">
                <div class="menuHamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="mainHeader__menu">
              <div class="mainHeader__menu_head"><?php echo LOGO; ?></div>
              <?php echo $oPage->listPagesMenu(1, Array('sClassName' => 'headerMenu', 'bExpanded' => TRUE, 'iDepthLimit' => 9, 'scroll' => ($aData['iPage'] == 1 ? TRUE : FALSE) ) );  ?>
              <?php echo contactsButtons(); ?>
              <div class="flex-justify mainHeader__icons">
                  <?php  echo socialMedia(array('contacts' => FALSE)); ?>
              </div>
              
            </div>
        </div>
    </div>
</header>
TEST GIT HUB

<?php if($aData['iPage'] == $config['video_page']){ ?>
<section class="videoHeader">
    <video class="videoHeader__background" autoplay loop muted="muted" playsinline>
        <source src="<?php echo IMAGES; ?>intro-video.mp4?ver=<?php echo filemtime("./images/intro-video.mp4"); ?>" type="video/mp4">
        Twoja przeglądarka nie obsługuje elementu wideo.
    </video>
    <div class="videoHeader__content showUp">
      <div class="contentParallax">
       <h1 class="mainSlider__title"><?php echo $config['slogan']; ?></h1>
        <div class="mainSlider__desc"><?php echo $config['description']; ?></div>
        <a href="<?php echo IMAGES; ?>avit-intro.mp4?ver=2"  class="videoHeader__button button mainSlider__button button-white" data-fancybox><img src="<?php echo ICONS; ?>play.svg" alt="">Zobacz film</a>
    </div>
    </div>
    <a class="videoHeader__arrow scrollTo" href="#" class="scroll-to" data-id="aboutUs"><img src="<?php echo ICONS; ?>arrow-long.svg" alt="Przeglądaj dalej"></a>
</section>
<?php } ?>
<?php if($aData['iPage'] == $config['slider_page']){ ?>
<script>
    $(document).ready(function() {
        $('.mainSlider__list').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            dots:true,
            autoplay:false,
            items:1,
        });
    });
</script>
<?php echo $oSlider->listSliders( array( 'sClassName' => 'mainSlider') ); } ?>
<main class="mainBody" id="smooth-scroll" >



 