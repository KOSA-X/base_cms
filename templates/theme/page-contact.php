<?php 
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
require_once 'templates/'.$config['skin'].'/_header.php';
require_once 'templates/'.$config['skin'].'/_title.php';
           
?>
<div class="container pageContact">
  <div class="mainPage__wrapper">


        <div class="mainPage__content ">
           
           
        
           
           
           <div class="row">
               <div class="col-6">
                <div class="pageContact__list">
                    <?php echo contacts(array('phone' => TRUE, 'email' => TRUE, 'location' => TRUE, 'hours' => TRUE)); ?>
                      
                </div>
                <div class="pageContact__socialmedia">
                 <?php echo socialMedia(); ?>  
            </div>
               </div>
               
                <div class="col-6">
                    <div class="pageContact__form">
              
              <div class="widget">
            <h5 class="widget__title"><img src="<?php echo ICONS; ?>send.svg" class="invert" alt="Wyślij wiadomość">Wyślij wiadomość</h5>
            <div class="widget__content">
                <?php include("plugins/contact-mail.php");  ?>
            </div>
             </div>
            </div>
                   
                    
               </div>
            </div>
             
             
            
               
               
              
                    <div class="widget">
                    <h5 class="widget__title"><img src="<?php echo ICONS; ?>home-line.svg" class="invert" alt="Dane firmowe">Dane firmowe</h5>
                    <div class="widget__content">
                           
                           
                        
                        <?php echo ($aData['sDescriptionFull'] != ""  ? $aData['sDescriptionFull'] : null); ?>
                        
                         
                     </div>
                     </div>
              

             <?php echo $oFile->listFiles( $aData['iPage'] ); ?>
             

        

       </div>
   </div>
    <?php echo $oPage->listPages($aData['iPage'], array('hide_cat' => TRUE, 'type' => $aData['sType'], 'class' => 'pagesList-'.$aData['iPage'])); ?>   
</div>
 
 
 <div class="pageContact__map">
   <div class="widget">
    <h5 class="widget__title"><img src="<?php echo ICONS; ?>location.svg" class="invert" alt="Lokalizacja"><a href="<?php echo $config['maps']; ?>" target="_blank" title="Uruchom nawigację">Nawigacja</a></h5>
    <div class="widget__content"> 
        <?php echo contacts(array('location' => TRUE)); ?>
    </div>

     <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2541.1633581155897!2d23.4257508!3d50.4380578!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4724afb806ed7e8b%3A0xd453297b44919eeb!2sOKR%C4%98GOWA%20STACJA%20KONTROLI%20POJAZD%C3%93W!5e0!3m2!1spl!2spl!4v1760983044148!5m2!1spl!2spl" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div> 


<?php 

require_once 'templates/'.$config['skin'].'/_footer.php'; ?>