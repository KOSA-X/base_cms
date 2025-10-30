<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sName'] ) ){
  $iPage = $oPage->savePage( $_POST );
  if( isset( $_POST['sOptionList'] ) )
    header( 'Location: '.$config['admin_file'].'?p=pages&sOption=save' );
  elseif( isset( $_POST['sOptionAddNew'] ) )
    header( 'Location: '.$config['admin_file'].'?p=pages-form&sOption=save' );
  else
    header( 'Location: '.$config['admin_file'].'?p=pages-form&sOption=save&iPage='.$iPage );
  exit;
}

if( isset( $_GET['iPage'] ) && is_numeric( $_GET['iPage'] ) ){
  $aData = $oPage->throwPageAdmin( $_GET['iPage'] );
}

$sSelectedMenu = 'pages';
$iPageParent = isset( $aData['iPageParent'] ) ? $aData['iPageParent'] : ( is_numeric( $config['default_page_parent'] ) ? $config['default_page_parent'] : null );
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>


  <form action="?p=<?php echo $_GET['p']; ?>" name="form" method="post" class="main-form">
  

  <header class="mainPage__header">
  
  <div class="pagesTree">
      <ol class="pagesTree__list">
          <li><a href="?p=pages">Strony</a></li>
          <li>Edycja zakładki</li>
        </ol>
</div>
  
  
   <h1 class="mainPage__title">
   
   <?php if( isset( $aData['iPage'] ) ){ ?>
        <a href="./<?php echo ( ( $config['start_page'] == $aData['iPage'] ) ? '?sLanguage='.$config['language'] : $oPage->aLinksIds[$aData['iPage']] ); ?>" title="<?php echo $lang['Preview']; ?>" class="link_underline"><?php echo $aData['sName']; ?></a> 

      <?php }else{
            echo ( isset( $aData['iPage'] ) ) ? $lang['Pages_form'].': '.$aData['sName'] : $lang['New_page']; 
        }
       ?></h1>
   
   <div class="mainPage__buttons d-flex ">
     
     <input type="submit" name="sOption" class="button button" value="<?php echo $lang['save']; ?>" />
     
     <?php if( isset( $aData['iPage'] ) ){ ?>
        <a href="./<?php echo ( ( $config['start_page'] == $aData['iPage'] ) ? '?sLanguage='.$config['language'] : $oPage->aLinksIds[$aData['iPage']] ); ?>" title="<?php echo $lang['Preview']; ?>" class="button button-border ml-2">Podgląd</a> 

      <?php } ?>
      
        
        
        <input type="submit" value="<?php echo $lang['save_add_new']; ?>" name="sOptionAddNew" class="button button-border ml-auto"/>
        <input type="submit" value="<?php echo $lang['save_list']; ?>" name="sOptionList" class="ml-2 button button-border" />
          
      
 
   </div>
   
 
   
</header>



 
 
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#pages-form" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }
  if( isset( $_GET['sOption'] ) ){
    echo '<div class="alert alert-info">'.$lang['Operation_completed'].'</div>';
  }?>
  


   
      <input type="hidden" name="iPage" id="iPage" value="<?php if( isset( $aData['iPage'] ) ) echo $aData['iPage']; ?>" />
      <input type="hidden" name="sType" value="<?php echo $aData['iMenu']; ?>" id="sType" size="75" />
      
 
      
      

      <ul class="tabs">
        <!-- tabs start -->
        <li id="content" class="selected"><a href="#content"><?php echo $lang['Content']; ?></a></li>
        <li id="options"><a href="#options"><?php echo $lang['Options']; ?></a></li>
        <li id="seo"><a href="#seo"><?php echo $lang['Seo']; ?></a></li>
        <li id="files"><a href="#files">Zdjęcia & <?php echo $lang['Files']; ?></a></li>
        <li id="add-files"><a href="#add-files"><?php echo $lang['Add_files']; ?></a></li>
        <!-- tabs end -->
      </ul>

      <ul id="tab-content" class="forms full tabsContent">
       
        <li>
         <div class="form-floating">
                <input type="text" class="form-control" id="sName" name="sName" value="<?php if( isset( $aData['sName'] ) ) echo $aData['sName']; ?>" placeholder="<?php echo $lang['only_this_field_is_required']; ?>" required data-form-check="required">
                <label for="sName"><?php echo $lang['Name']; ?></label>
            </div>
        </li>
        
        <li class="parent">
         <div class="form-item">
          <label for="iPageParent"><?php echo $lang['Parent_page']; ?></label>
          <select name="iPageParent" id="iPageParent" size="15"><option value=""<?php if( !isset( $iPageParent ) || $iPageParent == 0 ) echo ' selected="selected"'; ?>><?php echo $lang['none']; ?></option><?php echo $oPage->listPagesSelectAdmin( $iPageParent ); ?></select>
            </div>
        </li>
        
        <li>
         <div class="form-item">
              <label for="sDesc">Slogan</label>
              <input type="text" name="sDesc" id="sDesc" value="<?php if( isset( $aData['sDesc'] ) ) echo $aData['sDesc']; ?>"  />
          </div>
        </li>
        
        

        <li class="short-description">
         <div class="form-item">
          <label for="sDescriptionShort"><?php echo $lang['Short_description']; ?> <a href="#" class="expand"><span class="display"><?php echo $lang['Display']; ?></span><span class="hide"><?php echo $lang['Hide']; ?></span></a></label>
          <div class="toggle"><?php echo getTextarea( 'sDescriptionShort', isset( $aData['sDescriptionShort'] ) ? $aData['sDescriptionShort'] : null, Array( 'iHeight' => '120' ) ); ?></div>
            </div>
        </li>

        <li class="full-description">
         <div class="form-item">
          <label for="sDescriptionFull"><?php echo $lang['Full_description']; ?></label>
          <?php echo getTextarea( 'sDescriptionFull', isset( $aData['sDescriptionFull'] ) ? $aData['sDescriptionFull'] : null, Array( 'iHeight' => '300', 'sClassName' => 'text-editor full-description' ) ); ?>
            </div>
        </li>
         
        <!-- tab content -->
      </ul>

      <ul id="tab-options" class="forms list tabsContent">
        <li class="custom">
         <div class="form-item">
         <label for="iStatus"><?php echo $lang['Status']; ?></label>
    
          <?php echo getYesNoBox( 'iStatus', isset( $aData['iStatus'] ) ? $aData['iStatus'] : ( isset( $config['default_pages_status'] ) ? 1 : 0 ) ); ?>
          
            </div>
        </li>
        
        <li>
         <div class="form-item">
          <label for="iPosition"><?php echo $lang['Position']; ?></label>
          <input type="text" id="iPosition" name="iPosition" value="<?php echo isset( $aData['iPosition'] ) ? $aData['iPosition'] : 0; ?>" class="numeric" size="3" maxlength="4" />
            </div>
        </li>
        <li>
         <div class="form-item">
          <label for="sRedirect"><?php echo $lang['Address']; ?></label>
          <input type="text" name="sRedirect" value="<?php if( isset( $aData['sRedirect'] ) ) echo $aData['sRedirect']; ?>" id="sRedirect" size="75" placeholder="np. ?kontakt" />
            </div>
        </li>
        
        
        <li class="custom">
         <div class="form-item">
             <label for="sExpandMenu">Rozwijanie w nawigacji</label>
              <select name="sExpandMenu" id="sExpandMenu">
                 <option value="0" <?php echo $aData['sExpandMenu'] == 0 ? 'selected="selected"' : '' ?>>Nie</option>
                 <option value="1" <?php echo $aData['sExpandMenu'] == 1 ? 'selected="selected"' : '' ?>>Tak</option>
                 </select>
            </div>
        </li>
        
         <li class="custom">
         <div class="form-item">
             <label for="sPanel">Panel boczny</label>
             <select name="sPanel" id="sPanel">
                 <option value="0" <?php echo $aData['sPanel'] == 0 ? 'selected="selected"' : '' ?>>Nie</option>
                 <option value="1" <?php echo $aData['sPanel'] == 1 ? 'selected="selected"' : '' ?>>Tak</option>
                 </select>
            </div>
        </li>
         
          <li class="custom">
         <div class="form-item">
             <label for="sHide">Ukryj na liście podstron</label>
              <select name="sHide" id="sHide">
                 <option value="0" <?php echo $aData['sHide'] == 0 ? 'selected="selected"' : '' ?>>Nie</option>
                 <option value="1" <?php echo $aData['sHide'] == 1 ? 'selected="selected"' : '' ?>>Tak</option>
             </select>
            </div>
        </li>
        
        <li class="custom">
         <div class="form-item">
             <label for="sType">Typ</label>
              <select name="sType" id="sType">
                 <option value="0" <?php echo $aData['sType'] == 0 ? 'selected="selected"' : '' ?>>Standard</option>
                 <option value="1" <?php echo $aData['sType'] == 1 ? 'selected="selected"' : '' ?>>Sklep</option>
             </select>
            </div>
        </li>
        
         <li>
         <div class="form-item">
          <label for="iMenu"><?php echo $lang['Menu']; ?></label>
          <select name="iMenu" id="iMenu"><?php echo getSelectFromArray( $config['pages_menus'], isset( $aData['iMenu'] ) ? $aData['iMenu'] : $config['default_pages_menu'] ); ?></select>
             </div>
        </li>
        
        
        
        
            
        <li>
         <div class="form-item">
          <label for="iTheme"><?php echo $lang['Template']; ?></label>
          <select name="iTheme" id="iTheme"><?php echo getThemesSelect( isset( $aData['iTheme'] ) ? $aData['iTheme'] : $config['default_theme'] ); ?></select>
            </div>
        </li>
        
        <li><h5 class="form-separator">Dodatkowe parametry</h5></li>
        
        
        
        
        
        <li>
         <div class="form-item">
          <label for="sDate">Data publikacji</label>
          <input type="date" id="sDate" name="sDate" value="<?php echo isset( $aData['sDate'] ) ? $aData['sDate'] : 0; ?>" class="numeric" size="3" maxlength="4" />
            </div>
        </li>
        
        
        <li>
         <div class="form-item">
          <label for="sPrice">Cena</label>
          <input type="text" name="sPrice" value="<?php if( isset( $aData['sPrice'] ) ) echo $aData['sPrice']; ?>" id="sPrice" size="75" />
            </div>
        </li>
        
        
        <li class="custom">
         <div class="form-item">
             <label for="sCategory">Kategoria</label>
              <select name="sCategory" id="sCategory">
                <?php echo getSelectFromArray( $config['category'], isset( $aData['sCategory'] ) ? $aData['sCategory'] : 0 ); ?>
                
                 
                 </select>
            </div>
        </li>
        
      
        
       
        
    
        <!-- tab options -->
      </ul>

      <ul id="tab-seo" class="forms list tabsContent">
        <li>
         <div class="form-item">
          <label for="sTitle"><?php echo $lang['Page_title']; ?></label>
          <input type="text" name="sTitle" value="<?php if( isset( $aData['sTitle'] ) ) echo $aData['sTitle']; ?>" id="sTitle" size="75" />
            </div>
        </li>
        <li>
         <div class="form-item">
          <label for="sUrl"><?php echo $lang['Url_name']; ?></label>
          <input type="text" name="sUrl" value="<?php if( isset( $aData['sUrl'] ) ) echo $aData['sUrl']; ?>" id="sUrl" size="75" />
            </div>
        </li>
        <li>
         <div class="form-item">
          <label for="sDescriptionMeta"><?php echo $lang['Meta_description']; ?></label>
          <input type="text" name="sDescriptionMeta" value="<?php if( isset( $aData['sDescriptionMeta'] ) ) echo $aData['sDescriptionMeta']; ?>" id="sDescriptionMeta" size="75" />
            </div>
        </li>
        <!-- tab seo -->
      </ul>

      <section id="tab-add-files" class="forms files tabsContent">
        <script src="plugins/valums-file-uploader/fileuploader.min.js"></script>
        <div id="fileUploader">		
        </div>
         
        
   
        <h5 class="form-separator mb-4">Lub wybierz pliki z serwera wgrane już wcześniej i kliknij "Zapisz".</h5>
        
        <div id="files-dir" class="rwd-inner-container">
   
          <?php echo $oFile->listFilesInDir( Array( 'sSort' => 'time' ) ); ?>
        </div>
      </section>

      <section id="tab-files" class="forms files tabsContent">
        <?php
          if( isset( $aData['iPage'] ) ){
            $aData['sFileList'] = $oFile->listAllFiles( $aData['iPage'] );
          }
          echo isset( $aData['sFileList'] ) ? $aData['sFileList'] : '<div class="alert alert-info">'.$lang['Data_not_found'].'</div>';
        ?>
      </section>

       
   


  </form>

<script>
  // files tabs variables
  var sTypesSelect = '<?php echo getSelectFromArray( $config['images_locations'], $config['default_image_location'] ); ?>',
      sSizeSelect = '<?php echo getThumbnailsSelect( $config['default_image_size'] ); ?>';
  $(function(){
    // file uploader
    var uploader = new qq.FileUploader({
      element: document.getElementById('fileUploader'),
      action: aQuick['sPhpSelf']+'?p=ajax-files-upload',
      inputName: 'sFileName',
      uploadButtonText: '<?php echo addslashes( $lang['Files_from_computer'] ); ?>',
      cancelButtonText: '<?php echo addslashes( $lang['Cancel'] ); ?>',
      failUploadText: '<?php echo addslashes( $lang['Upload_failed'] ); ?>',
      <?php echo ( isset( $config['enable_files_uploader_dropzone'] ) ? 'hideDropzones: false,' : null ); ?>
      dragText: '<?php echo addslashes( $lang['Drop_files_to_upload'] ); ?>',
      onComplete: function(id, fileName, response){
        if (!response.success){
          return;
        }
        if( uploader.getInProgress() == 0 )
          refreshFiles( );
        if( response.size_info ){
          qq.addClass(uploader._getItemByFileId(id), 'qq-upload-maxdimension');
          uploader._getItemByFileId(id).innerHTML += '<span class="qq-upload-warning"><?php echo addslashes( $lang['Image_over_max_dimension'] ); ?></span>';
        }
      }
    });

    displayTabInit( checkPagesTab );
    checkPageParent(); // hide menu field for subpages
    $( '#iPageParent' ).on( 'change', checkPageParent );
    checkChangedFile( ); // was there any changes in files tab
    $( ".main-form" ).quickform();

    // Hide/show links
    $( '#tab-content li.short-description label a.expand' ).click( function(){ displayShortDescriptionField( true ) } );
    <?php
    if( !empty( $aData['sDescriptionShort'] ) ){
      echo 'displayShortDescriptionField( false );';
    }
    ?>

    filesFromServerEvents( );

  });
</script>
<?php
require_once 'templates/admin/_footer.php';
?>
