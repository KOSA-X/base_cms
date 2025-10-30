<?php 
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
require_once 'templates/'.$config['skin'].'/_header.php';

?>
 
<section class="section aboutUs">
    <div class="section__scroll" id="section-aboutUs"></div>
    <div class="container">
       <div class="section__bg"></div>
       
       <div class="aboutUs__content">
          
           <header class="section__header showUp">
              
                      <div class="section__subtitle"><a href="<?php echo getUrl($config['about_page']); ?>"><?php echo getData($config['about_page'], "sName"); ?></a></div>
                   <h2 class="section__title text-glow"><?php echo $config['slogan']; ?></h2>
                   
               
            </header>
            
            <div class="section__desc showUp">
                <?php echo getData($config['about_page'], "sDescriptionShort"); ?>
                <p class="mt-3"><a href="<?php echo getUrl($config['about_page']); ?>" class="link_underline"><?php echo $lang['read_more']; ?></a></p>
            </div>
            <div class="aboutUs__gallery negativeMargin showUp">
                <?php echo $oFile->listImages($config['about_page'], Array( 'iType' => 1,   'slider' => TRUE,  'full_image' => TRUE,  'parallax' => TRUE)); ?>
            </div>
            <div class="aboutUs__contact">
              <header class="section__header showUp">
                  <h3 class="section__title"><?php echo getData($config['contact_page'], "sDesc"); ?></h3>
            </header>
               <div class="row">
                  <div class="col-6 showUp">
                       <?php echo contacts(array('phone' => TRUE, 'email' => TRUE)); ?>
                       <?php echo socialMedia(); ?>
                  </div>
                   <div class="col-6 showUp">
                       <?php echo contacts(array('location' => TRUE, 'hours' => TRUE)); ?>
                   </div>
               </div>
           </div>
       </div>
    </div>
</section>
 
 

<section class="section ourOffer">
  <div class="section__scroll" id="section-ourOffer"></div>
   <div class="container">
       <header class="section__header showUp">
           <div class="section__subtitle"><a href="<?php echo getUrl($config['offer_page']); ?>"><?php echo getData($config['offer_page'], "sName"); ?></a></div>
            <h2 class="section__title text-glow"><?php echo getData($config['offer_page'], "sDesc"); ?></h2>
      </header>
      <div class="ourOffer__content">
          <?php echo $oPage->listPages($config['offer_page'], array( 'class' => 'ourOffer__list', 'icon' => TRUE)); ?>
      </div>
   </div>
</section>


<section class="section ourProjects">
  <div class="section__scroll" id="section-ourProjects"></div>
   <div class="container">
       <header class="section__header showUp">
          <div class="row">
              <div class="col-6">
                   <div class="section__subtitle"><a href="<?php echo getUrl($config['projects_page']); ?>"><?php echo getData($config['projects_page'], "sName"); ?></a></div>
                    <h2 class="section__title text-glow"><?php echo getData($config['projects_page'], "sDesc"); ?></h2>
              </div>
              <div class="col-6">
                <div class="project__categoryButtons activeLink">
                     <?php echo listElements($config['category'], array('url' => getUrl($config['projects_page']))); ?>
                 </div>
               
              </div>
          </div>
      </header>
      <div class="ourProjects__content">
          <?php echo $oPage->listPages($config['projects_page'], array()); ?>
      </div>
   </div>
</section>


<section class="section clients">
  <div class="section__scroll" id="section-clientsLogo"></div>
   <div class="container">
       <header class="section__header showUp">
           <div class="section__subtitle"><a href="<?php echo getUrl(19); ?>"><?php echo getData(19, "sName"); ?></a></div>
            <h2 class="section__title text-glow"><?php echo getData(19, "sDesc"); ?></h2>
      </header>
      <div class="clientsLogo__content">
          <?php echo $oFile->listImages(19, Array( 'iType' => 2, 'class' => 'galleryLogo')); ?>
      </div>
   </div>
</section>




<section class="section faq">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <header class="section__header showUp">
                   <div class="section__subtitle"><a href="<?php echo getUrl($config['faq_page']); ?>"><?php echo getData($config['faq_page'], "sName"); ?></a></div>
                    <h2 class="section__title text-glow"><?php echo getData($config['faq_page'], "sDesc"); ?></h2>
                </header>
            </div>
            <div class="col-8">
                <div class="faq__content">
                    <?php echo $oPage->listAccordion($config['faq_page'], array( 'bNoLinks' => TRUE)); ?>
                </div>
            </div>
        </div>
    </div>
</section>
 
 
<section class="section cta">
   <div class="section__scroll" id="section-cta"></div>
        <div class="cta__wrapper">
            <header class="section__header showUp">
                   <div class="section__subtitle"><a href="<?php echo getUrl($config['contact_page']); ?>"><?php echo getData(18, "sName"); ?></a></div>
                    <h2 class="section__title"><?php echo getData(18, "sDesc"); ?></h2>
                </header>
            <div class="cta__desc"><?php echo getData(18, "sDescriptionShort"); ?></div>
            <div class="cta__more"><a href="<?php echo getUrl($config['contact_page']); ?>" class="button"><?php echo getData($config['contact_page'], 'sName'); ?></a></div>
    </div>
</section>


<div class="section shopIndex">
    <div class="section__scroll" id="section-shopIndex"></div>
    <div class="container">
        <header class="section__header showUp">
            <div class="section__subtitle"><a href="<?php echo getUrl($config['shop_page']); ?>"><?php echo getData($config['shop_page'], "sName"); ?></a></div>
            <h2 class="section__title text-glow"><?php echo getData($config['shop_page'], "sDesc"); ?></h2>
        </header>
        <script>
                $(document).ready(function() {
                    $('.shopIndex__products').owlCarousel({
                        loop:false,
                        margin: 20,
                        nav:false,
                        dots:true,
                        autoplay:false,
                        autoplayHoverPause:true,
//                        animateOut: 'fadeOut',
                        autoplayTimeout: 50000,
                        stagePadding: 40,
                        responsive : {
                            0 : {
                               items: 1,
                            },
                            578 : {
                                items: 2,
                                stagePadding: 0,
                            },
                            768 : {
                                items: 3,
                                stagePadding: 0,
                            },
                            992 : {
                                items: 4,
                                nav:true,
                                stagePadding: 0,
                            }
                        }
                    });
                });
            </script>
            <div class="shopIndex__content negativeMargin showUp">
                <?php echo listPages(array('sql' => 'iPageParent!=0 AND iMenu=2', 'hide_cat' => TRUE, 'hide_desc' => TRUE, 'class' => 'productsList owl-carousel shopIndex__products')); ?>
            </div>
    </div>
</div>

 

<hr class="separator showUp my-3">

<div class="section blogIndex">
    <div class="section__scroll" id="section-blogIndex"></div>
    <div class="container">
        <header class="section__header showUp">
            <div class="section__subtitle"><a href="<?php echo getUrl($config['blog_page']); ?>"><?php echo getData($config['blog_page'], "sName"); ?></a></div>
            <h2 class="section__title text-glow"><?php echo getData($config['blog_page'], "sDesc"); ?></h2>
        </header>
        <script>
                $(document).ready(function() {
                    $('.blogIndex__list').owlCarousel({
                        loop:false,
                        margin: 20,
                        nav:false,
                        dots:true,
                        autoplay:false,
                        autoplayHoverPause:true,
//                        animateOut: 'fadeOut',
                        autoplayTimeout: 50000,
                        stagePadding: 40,
                        responsive : {
                            0 : {
                               items: 1,
                            },
                            1200 : {
                                items: 2,
                                nav:true,
                                stagePadding: 0,
                            }
                        }
                    });
                });
            </script>
            <div class="blogIndex__content negativeMargin showUp">
                <?php echo $oPage->listPages($config['blog_page'], array('hide_cat' => FALSE, 'limit' => 9, 'class' => 'blogIndex__list owl-carousel')); ?>
            </div>
    </div>
</div>
 
 
 

 

 
 
<?php require_once 'templates/'.$config['skin'].'/_footer.php'; ?>