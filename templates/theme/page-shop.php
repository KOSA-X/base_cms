<?php 
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
require_once 'templates/'.$config['skin'].'/_header.php';

if( isset( $aData['sName'] ) ){
    require_once 'templates/'.$config['skin'].'/_title.php';
           
?>
<div class="container">

  <div class="mainPage__wrapper shopPage">
    <?php require_once 'templates/'.$config['skin'].'/_column.php'; ?>

        <div class="mainPage__content">
        
        <?php if($aData['sPrice'] != ""){ ?>
           <article class="mainPage__article negativeMargin productMore">
           
            <div class="row">
                <div class="col-6">
                    <?php echo $oFile->listImages( $aData['iPage'], Array( 'iType' => 1,  'slider' => TRUE, 'class' => 'productMore__gallery negativeMargin')); ?>
                </div>
                <div class="col-6">
                   <div class="productMore__content">
                        <?php echo ($aData['sDescriptionShort'] != ""  ? '<div class="mainPage__descShort">'.$aData['sDescriptionShort'].'</div>' : null); ?>
                        <div class="productMore__price">
                            <div class="label">Cena</div>
                            <div class="value"><?php echo $aData['sPrice']; ?> zł</div>
                        </div>
                        <button class="add-to-cart button button-lg w-100" data-product-id="<?php echo $aData['iPage']; ?>" data-action="add"><img src="<?php echo ICONS; ?>cart.svg" alt="Dodaj do koszyka">Dodaj do koszyka</button>
                    </div>
                </div>
            
            </div>
            
                 <?php echo (($aData['sDescriptionFull'] != "" && $aData['sDescriptionFull'] != $aData['sDescriptionShort'] ) ? '<div class="mainPage__descFull">'.$aData['sDescriptionFull'].'</div>' : null); ?>
                 <?php echo $oFile->listFiles( $aData['iPage'] ); ?>
             
            
            
            <?php echo $oFile->listImages( $aData['iPage'], Array( 'iType' => 3, 'class' => 'galleryGrid productMore__galleryGrid')); ?>
            
            
             </article>
             
            
            
           
            
        
             
             
             
             
        <?php }else{
               
               
            $content = "";
            $content .= ($aData['sDescriptionShort'] != ""  ? '<div class="mainPage__desc font-md">'.$aData['sDescriptionShort'].'</div>' : null);
    
    
               
            $content .= $oFile->listImages( $aData['iPage'], Array( 'iType' => 1, 'class' => 'mainPage', 'full_image' => TRUE,  'parallax' => TRUE,  'slider' => TRUE));
               
            $content .= (($aData['sDescriptionFull'] != "" && $aData['sDescriptionFull'] != $aData['sDescriptionShort'] ) ? '<div class="mainPage__desc">'.$aData['sDescriptionFull'].'</div>' : null);
            $content .= $oFile->listFiles( $aData['iPage'] );
               
               
            if($content != ""){
                echo '<article class="mainPage__article negativeMargin">'.$content.'</article>';
            }
               
        
        
       
            if(SHOP_PAGE){
                // głowna strona sklepu
                echo listPages(array('sql' => 'iPageParent!=0 AND iMenu=2', 'class' => 'productsList pagesList-'.$aData['iPage']));
            }else{
                echo $oPage->listPages($aData['iPage'], array('hide_cat' => TRUE));
            }
      ?>   
         
         <?php echo $oFile->listImages( $aData['iPage'], Array( 'iType' => 3, 'class' => 'galleryGrid')); ?>

         <?php echo ($aData['sDate'] ? '<div class="mainPage__date">Data publikacji '.$aData['sDate'].'</div>' : null); ?>

         
         
         <?php } ?>

       </div>
   </div>
   
   
   <?php if($aData['sPrice'] != ""){ ?>
     <hr class="separator">
             
        <div class="productMore__discover">
            <header class="section__header">
                   <h2 class="section__title">Zobacz więcej</h2>
            </header>
           <script>
                $(document).ready(function() {
                    $('.ourProducts__slider').owlCarousel({
                        loop:true,
                        margin: 20,
                        nav:true,
                        dots:true,
                        autoplay:true,
                        autoplayHoverPause:true,
//                        animateOut: 'fadeOut',
                        autoplayTimeout: 5000,
                        responsive : {
                            0 : {
                               items: 1,
                            },
                            578 : {
                                items: 1,
                            },
                            768 : {
                                items: 2,
                            },
                            992 : {
                                items: 3,
                            },
                            1200 : {
                                items: 4,
                            }
                        }
                    });
                });
            </script>
            <?php echo $oPage->listPages($aData['iPageParent'], array('hide_cat' => TRUE, 'class' => 'ourProducts__slider owl-carousel')); ?>
        </div>
    <?php } ?>
        
    
</div>
 
<?php 
} else{ 
    require_once 'templates/'.$config['skin'].'/_404.php';
}

require_once 'templates/'.$config['skin'].'/_footer.php'; ?>