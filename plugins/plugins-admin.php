<?php

/**
* Function returns code for tinymce wysiwyg editor
* @return string
* @param  string  $sName
* @param  string  $sContent
* @param array $aParametersExt
* Default options: sToolbar, sPlugins
*/
function getWysiwygTinymce( $sName, $aParametersExt ){
  $content = null;
    global $config;
  if( !defined( 'WYSIWYG_START' ) ){
    define( 'WYSIWYG_START', true );
    $content .= '<script src="templates/admin/js/tinymce/tinymce.min.js"></script>';
  }
    
    if($sName == 'sDescriptionShort'){
        // PROSTY UKŁAD
        
        $content .= '<script>
      tinymce.init({
        selector: "textarea#'.$sName.'",
         convert_urls: true,
         relative_urls: false,
          remove_script_host: false,
  
        language: "pl",
              height : 300,
            language_url : "templates/admin/js/tinymce/langs/pl.js",
            
        license_key: "gpl|'.$config['tinymce'].'",
         plugins: " autolink charmap codesample image link lists  searchreplace  code",
    toolbar: "bold italic underline strikethrough | link  | numlist bullist | removeformat",
      });
    </script>';
        
    }else{
        $content .= '<script>
      tinymce.init({
        selector: "textarea#'.$sName.'",
        convert_urls: true,
         relative_urls: false,
          remove_script_host: false,
        language: "pl",
              height : 600,
            language_url : "templates/admin/js/tinymce/langs/pl.js",
            
        license_key: "gpl|'.$config['tinymce'].'",
         plugins: "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code",
    toolbar: "undo redo | blocks fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat",
      });
    </script>';
    }

  
  return $content;
} // end function getWysiwygTinymce

?>