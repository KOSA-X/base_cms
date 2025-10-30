<?php 
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
require_once 'templates/'.$config['skin'].'/_header.php';

if( isset( $aData['sName'] ) ){
    require_once 'templates/'.$config['skin'].'/_title.php';
           
?>
<div class="container">
  <div class="mainPage__wrapper">
    <?php require_once 'templates/'.$config['skin'].'/_column.php'; ?>

        <div class="mainPage__content">
        
                  


<?php if($aData['iPage'] == $config['projects_page']){ // REALIZACJE ?>
<div class="project__categoryButtons project__categoryFilter activeLink">
     <?php echo listElements($config['category'], array()); ?>
 </div>
<?php } ?>

             
         <?php  
 
    
            
            $content = "";
            $content .= ($aData['sDescriptionShort'] != ""  ? '<div class="mainPage__descShort">'.$aData['sDescriptionShort'].'</div>' : null);
    
    
    
    
              
              
               
            $content .= $oFile->listImages( $aData['iPage'], Array( 'iType' => 1, 'class' => 'mainPage', 'full_image' => TRUE,  'parallax' => TRUE,  'slider' => TRUE, 'class' => 'negativeMargin'));
               
            $content .= (($aData['sDescriptionFull'] != "" && $aData['sDescriptionFull'] != $aData['sDescriptionShort'] ) ? '<div class="mainPage__descFull">'.$aData['sDescriptionFull'].'</div>' : null);
            $content .= $oFile->listFiles( $aData['iPage'] );
               
               
            if($content != ""){
                echo '<article class="mainPage__article negativeMargin">'.$content.'</article>';
            }
           
               
               
            ?>
        
         
         

         <?php echo $oFile->listImages( $aData['iPage'], Array( 'iType' => 3, 'class' => 'galleryGrid')); ?>

         <?php echo ($aData['sDate'] ? '<div class="mainPage__date">Data publikacji '.$aData['sDate'].'</div>' : null); ?>
         
      

       </div>
   </div>
   
    <?php echo $oPage->listPages($aData['iPage'], array('type' => $aData['sType'], 'footer' => TRUE)); ?>   
</div>
 
<?php 
} else{ 
    require_once 'templates/'.$config['skin'].'/_404.php';
}

require_once 'templates/'.$config['skin'].'/_footer.php'; ?>