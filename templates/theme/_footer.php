<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
?>
<footer class="mainFooter">
    <div class="container">
        <div class="mainFooter__row">
           <div class="mainFooter__column">
               <div class="mainFooter__logo"><?php echo $logo; ?></div>
               <div class="mainFooter__slogan"><?php echo $config['slogan']; ?></div>
               <div class="mainFooter__desc"><?php echo $config['description']; ?></div>
               <?php echo socialMedia(); ?>
           </div>
           <div class="mainFooter__column">
               <h5 class="mainFooter__title">Nawigacja</h5>
               <?php echo $oPage->listPagesMenu( 1, Array( 'sClassName' => 'footerMenu', 'bExpanded' => FALSE, 'iDepthLimit' => 0 ) );  ?>
           </div>
           <div class="mainFooter__column">
               <h5 class="mainFooter__title">Kontakt</h5>
               <?php echo contacts(array('phone' => TRUE, 'email' => TRUE, 'location' => TRUE)); ?>
           </div>
        </div>
        
    </div>
    <div class="mainFooter__bottom">
        <div class="container">
            <div class="mainFooter__info">
                <div class="copy"><?php echo $config['foot_info']; ?> <?php echo date("Y"); ?> ©  <a href="<?php echo getUrl($config['private_policy']); ?>" ><?php echo getData($config['private_policy'], 'sName'); ?></a> </div>
            </div>
            <div class="mainFooter__author">
                <span class="designer"><a href="https://kosa-x.com/" target="_blank" title="KOSΛ X">KOSΛ X</a></span><span class="cms"><a href="http://opensolution.org/" target="_blank" title="CMS by Quick.CMS">CMS by Quick.CMS</a></span>
                
            </div>
        </div>
    </div>
</footer>
</main> <!-- /mainBody --> 
<script async defer type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>  
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "url": "<?php echo CURRENT_URL; ?>",
  "logo": "<?php echo LOGO_URL; ?>"
}
</script> 
</body>
</html>