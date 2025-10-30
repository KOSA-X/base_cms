<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;

/**
* Displays page in the menu - default settings
* @return string
* @param array $aDatad
* @param array $aParametersExt
*/




function listPagesMenuView( $aData, $aParametersExt ){
    $sClassName = null;
    $submenu = FALSE;
    $arrow = "";
    $link = "";
    $sSubMenu = $aParametersExt['sSubMenu'];
    $oFile = Files::getInstance( );
    global $config;
    
    $icon_url = $oFile->getDefaultImageUrl( $aData['iPage'], Array( 'iType' => 2, 'sLink' => ( !isset( $aParametersExt['bNoLinks'] ) ? $aData['sLinkName'] : null ), 'bNoLinks' => ( isset( $aParametersExt['bNoLinks'] ) ? true : null ) ) );
    
    $icon = $icon_url ? "<img src='".$icon_url."' alt='".$aData['sName']."' class='menu_icon invert'>" : "";
    

    if( isset( $aParametersExt['bSelected'] ) )
        $sClassName .= ' selected';

    if($aData['sExpandMenu'] == 0){
        $sSubMenu = FALSE;
    }

    if( $sSubMenu ){
        $sClassName .= ' menu_item_submenu';
        $arrow = '<span class="menu_arrow invert" data-menu="'.$aData['iPage'].'"></span>';
    }

    if( $aData['iPageParent'] > 0 )
        $submenu = TRUE;
    
    
 
       return '<li class="'.( $submenu ? "submenu_item" : "menu_item" ).( isset( $sClassName ) ? $sClassName : null ).'" id="menu_item_'.$aData['iPage'].'">'.$icon.'<a href="'.$aData['sLinkName'].'" class="'.( $submenu ? "submenu_link" : "menu_link" ).'" title="'.$aData['sName'].'">'.$aData['sName'].'</a>'.$arrow.$sSubMenu.'</li>';
   
        
    
  
}  // end function listPagesMenu

/**
* Displays page in the list - default settings
* @return string
* @param array $aData
* @param array $aParametersExt
*/


function listMenuView($aData, $aParametersExt){
  return '<a href="'.$aData['sLinkName'].'" class="widget__link'.($aParametersExt['selected'] ? ' selected' : null).'">'.$aData['sName'].'</a>';
}


function listPagesView( $aData, $aParametersExt ){
    global $lang, $config;
  $oFile = Files::getInstance( );
    $class = "";
    $footer = "";
    $image = "";
    $price = "";
    $parametrs = "";
    $project_category = "";
    $image_full = "";
    $desc = "";
    $horizontal = FALSE;
    $category = "";
    $class = " pageItem-".$aData['iPage'];
    $popup = isset( $aParametersExt['popup'] ) ? $aParametersExt['popup'] : FALSE;
    $popup_content = "";
    
    
    // AKTUALNOŚCI
    
    if($aData['iPageParent'] == $config['blog_page']){
        $horizontal = TRUE;
        $class .= " eee";
    }
    
    
    // KATEGORIA
    
    if($aData['sCategory'] != '' && $aData['sCategory'] != 0){
        $project_category = " category='".$aData['sCategory']."' ";
        
        $category = '<div class="category"><a href="'.getUrl($aData['iPageParent']).'#category-'.$aData['sCategory'].'">'.getElement($aData['sCategory'], $config['category']).'</a></div>';
    
    }elseif($aData['iPageParent'] != 0 && !isset( $aParametersExt['hide_cat'] )){
        $category = '<div class="category"><a href="'.$aParametersExt['category_url'].'">'.getData($aData['iPageParent'], "sName").'</a></div>';
    }
    
    
    // LINK DO PUPUP LUB NIE
    if($popup){
        $link = '<a href="javascript:;" data-fancybox data-src="#pagePopup-'.$aData['iPage'].'" title="'.$aData['sName'].'">';
        
    }else{
        $link = ( !isset( $aParametersExt['bNoLinks'] ) ? '<a href="'.$aData['sLinkName'].'" title="'.$aData['sName'].'" >' : null );
    }
    
    
    
         
    

//    $image = $oFile->getDefaultImage( $aData['iPage'], array( 'sLink' => $link ) );
    
   
    
    // ZDJĘCIE LUB IKONA    
    if( isset($aParametersExt['icon']) && $aParametersExt['icon'] == TRUE || $aData['iPageParent'] == $config['offer_page']){
//        $class .= " pageItem_icon";
        $icon = TRUE;
    }else{
        $icon = FALSE;
    }
    
     $image = $oFile->getDefaultImage( $aData['iPage'], array( 'sLink' => $link, 'full_size' => $icon) );
    
    
    // POPUP
    if($popup){
        $class .= " pageItem-popup";
        $popup_content .= '<div class="popup" style="display:none" id="pagePopup-'.$aData['iPage'].'"><a href="" style="width:0px;border:0;height:0;outline:0"></a>';
        
        $popup_content .= ($image_full != "" ? '<div class="popup__image">'.$image_full.'</div>' : "");
        
        $popup_content .= '<h3 class="popup__title">'.$aData['sName'].'</h3>
         '.($aData['sDescriptionShort'] != "" ? '<div class="popup__lead">'.$aData['sDescriptionShort'].'</div>' : '').'
         <div class="popup__desc">'.$aData['sDescriptionFull'].'</div>';
        
        $popup_content .= $oFile->listImages( $aData['iPage'], Array( 'iType' => 3, 'class' => 'galleryGrid'));
        
        $popup_content .= '</div>';
        
//        $link = "";
    }
    
    
    
    
    $parametrs .= $aData['project_area'] != '' ? '<li class="project_area"><span class="label">Powierzchnia</span> <span class="value">'.$aData['project_area'].' m²</span></li>' : '';
    $parametrs .= $aData['project_volume'] != '' ? '<li class="project_volume"><span class="label">Kubatura</span> <span class="value">'.$aData['project_volume'].' m³</span></li>' : '';
    
    if($parametrs != ''){
        $desc = '<ul class="parametrs">'.$parametrs.'</ul>';
    }
    
    
    
    
    // OPIS 
    if(isset($aData['sPrice']) && $aData['sPrice'] != ""){
        $price = '<div class="price">'.$aData['sPrice'].' zł</div>';
    }
    
    
    if( !isset($aParametersExt['hide_desc'])){
        
        if(!empty( $aData['sDesc'] )){
            $desc = '<div class="desc">'.trunc($aData['sDesc'], ($popup ? 50 : 30)).'</div>';
        }elseif(!empty( $aData['sDescriptionShort'] )){
            $desc = '<div class="desc">'.trunc($aData['sDescriptionShort'], ($popup ? 50 : 30)).'</div>';
        }elseif(!empty( $aData['sDescriptionFull'] )){
            $desc = '<div class="desc">'.trunc($aData['sDescriptionFull'], ($popup ? 50 : 30)).'</div>';
        }
    }
    
  
    
    if(!$popup){
        $footer = '<footer class="footer">';
        if($price){
            $footer .= $price;    
            $footer .= '<button class="add-to-cart button button-light button-xs" data-product-id="'.$aData['iPage'].'" data-action="add" title="Do koszyka"><img src="'.ICONS.'cart.svg" alt="Koszyk" class="invert">Do koszyka</button>';   

        }else{
            $footer .= '<a href="'.$aData['sLinkName'].'" title="'.$aData['sName'].'" class="link_underline">'.$lang['more'].'</a>';
            $footer .= ( !empty( $aData['sDate'] ) ? '<time class="date">'.$aData['sDate'].'</time>' : null );
        }
        $footer .= '</footer>';
    }
    
    
    
            
  return '<li class="pageItem'.$class.'" '.$project_category.'>'
        .$image.
        '<div class="content">'
            .$category.
            '<h3 class="title">'.$link.$aData['sName'].( $link != "" ? '</a>' : null ).'</h3>'. 
            $desc.
        ($horizontal ? $footer : '').
        
        '</div>'.
        ($horizontal ? '' : $footer).$popup_content.
      '<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": "'.$aData['sName'].'"
    }
    </script></li>
    ';
      
//    ( !empty( $aData['sPrice'] ) ? '<div class="price">'.($aData['sPrice']).' <span class="currncy">zł</span></div>' : null ). // short description here
     
      
//    shareIcons($aData['iPage']).
    
}

function listAccordionView( $aData, $aParametersExt ){
    global $lang;
  $oFile = Files::getInstance( );
    $class = "";
    $footer = "";
    $image = "";
    $price = "";
    $image_full = "";
    $desc = "";
    $category = "";
    $class = " pageIt-".$aData['iPage'];
    $popup = isset( $aParametersExt['popup'] ) ? $aParametersExt['popup'] : FALSE;
    $popup_content = "";
    
    $i = 1;
    
     
    
    

     
    $link = ( !isset( $aParametersExt['bNoLinks'] ) ? '<a href="'.$aData['sLinkName'].'" title="'.$aData['sName'].'" class="button">'.$lang['more'].'</a>' : null );
  
         
    
    
    // ZDJĘCIE LUB IKONA    
    if( isset($aParametersExt['icon']) && $aParametersExt['icon'] == TRUE){
        $image = "<div class='icon'>".$link."<img src='".$oFile->getDefaultImageUrl( $aData['iPage'])."' alt='".$aData['sName']."' class='invertImg'>".($link != "" ? "</a>" : "")."</div>";
        $image_full = $image;
        $class .= " pageItem_icon";
    }else{
        $image = $oFile->getDefaultImage( $aData['iPage'], array( 'sLink' => $link ) );
        $image_full = $oFile->getDefaultImage( $aData['iPage'], array( 'sLink' => FALSE, 'full_size' => TRUE ) );
    }
    
    
    // POPUP
    if($popup){
        $class .= " pageItem-popup";
        $popup_content = '<div class="popup" style="display:none" id="pagePopup-'.$aData['iPage'].'"><a href="" style="width:0px;border:0;height:0;outline:0"></a>
        
        '.($image_full != "" ? '<div class="popup__image">'.$image_full.'</div>' : "").'
        <h4 class="popup__title">'.$aData['sName'].'</h4>
         '.($aData['sDescriptionShort'] != "" ? '<div class="popup__lead">'.$aData['sDescriptionShort'].'</div>' : '').'
         <div class="popup__desc">'.$aData['sDescriptionFull'].'</div>
         </div>';
        
//        $link = "";
    }
    
    
    
     
    
    if( !isset($aParametersExt['hide_desc'])){
        
        if(!empty( $aData['sDesc'] )){
            $desc = '<div class="desc">'.trunc($aData['sDesc'], ($popup ? 50 : 20)).'</div>';
        }elseif(!empty( $aData['sDescriptionShort'] )){
            $desc = '<div class="desc">'.$aData['sDescriptionShort'].'</div>';
        }elseif(!empty( $aData['sDescriptionFull'] )){
            $desc = '<div class="desc">'.trunc($aData['sDescriptionFull'], 50).'</div>';
        }
    }

   
    
     
    
            
  return '<li class="accordionItem'.$class.'" >
  
  <h3 class="accordionItem__title"><span class="label">'.$aData['sName'].'</span><span class="arrow invert"><img src="'.ICONS.'arrow.svg" alt="Arrow"></span></h3>
        <div class="accordionItem__content">'
            .$desc. $link.
        '</div><script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": "'.$aData['sName'].'"
    }
    </script></li>
    ';
      
    
//    ( !empty( $aData['sPrice'] ) ? '<div class="price">'.($aData['sPrice']).' <span class="currncy">zł</span></div>' : null ). // short description here
     
      
//    shareIcons($aData['iPage']).
    
} // end function listPagesView


function listFaqView( $aData, $aParametersExt ){
  $oFile = Files::getInstance( );
    $class = "";
    $class = " faqItem-".$aData['iPage'];
    
  return '<li class="faqItem'.$class.'">
  <h3 class="title"><a href="#" class="faqItemCollapse" data-id="'.$aData['iPage'].'" >'.$aData['sName'].'<span class="icon invertImg"></span></a></h3>
    <div class="content">'.$aData['sDescriptionShort'].'</div>
    </li>';
} 
 

/**
* Displays images
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listImagesView( $aData, $aParametersExt ){
  //return '<li'.( ( $aParametersExt['iElement'] % 4 ) == 1 ? ' class="row"' : null ).'>'. // oldie
    $class = "";
    $thumb = $aData['iSize'].'/';
    $desc = "";
    $title = !empty( $aData['sTitle'] ) || !empty( $aData['sDescription'] ) ? $aData['sTitle']. " ".$aData['sDescription'] : "Zdjęcie ".$aData['sFileName'];
    $youtube = !empty( $aData['sYoutube'] ) ? "data-src='".$aData['sYoutube']."'" : "";
    $parallax = !empty( $aParametersExt['parallax'] ) && $aParametersExt['parallax'] == TRUE ? " imageParallax" : "";
    
    if(isset($aParametersExt['full_image']) && $aParametersExt['full_image'] == TRUE){
        $thumb = "";
    }    
    $image = '<picture class="galleryItem__image'.$parallax.'"><img src="'.FILES.$thumb.$aData['sFileName'].'" alt="'.$title.'" /></picture>';
    
    if(isset($aData['sUrl']) && $aData['sUrl'] != ""){
        $link = ' href="'.$aData['sUrl'].'" target="_blank"';
    }else{
        $link = 'href="'.FILES.$aData['sFileName'].'" data-fancybox="gallery['.( isset( $aData['iPage'] ) ? $aData['iPage'] : 0 ).']" title="'.$title.'" data-caption="'.(!empty( $aData['sTitle'] ) ? "<h5>".$aData['sTitle']."</h5>" : "").$aData['sDescription'].'"';
    }
    
  return '<li class="galleryItem'.$class.'" id="galleryItem-'.$aData['iFile'].'">'.
  ( !isset( $aParametersExt['bNoLinks'] ) ? '<a '.$youtube.' '.$link.' title="'.$title.'">'.($youtube ? '<span class="youtube"><img src="images/icons/play-button.png"></span>' : "" ) : null ).$image.(!empty( $aData['sDescription'] ) ? '<div class="galleryItem__desc">'.$aData['sDescription'].'</div>' : "").( !isset( $aParametersExt['bNoLinks'] ) ? '</a>' : null ).'</li>';
} // end function listImagesView

/**
* Displays files
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listFilesView( $aData, $aParametersExt ){
  return '<li class="'.$aData['sIconStyle'].'"><a href="files/'.$aData['sFileName'].'" target="_blank" class="link_underline">'.$aData['sFileName'].'</a>'.( !empty( $aData['sDescription'] ) ? '<p>'.$aData['sDescription'].'</p>' : null ).'</li>';
} // end function listFilesView

/**
* Displays sliders
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listSlidersView( $aData, $aParametersExt ){
    global $lang;
  return '<li id="'.( !empty( $aParametersExt['sClassName'] ) ? $aParametersExt['sClassName'].'__item' : 'slider').'-'.$aData['iSlider'].'" class="'.( !empty( $aParametersExt['sClassName'] ) ? $aParametersExt['sClassName'].'__item' : null).'">
  
  '.( !empty( $aData['sFileName'] ) ? '<div class="mainSlider__image" style="background-image:url(\''.FILES.$aData['sFileName'].'\')"  /></div>' : null ).
      

    '<div class="mainSlider__content"><div class="container">'.
      
    ( !empty( $aData['sTitle'] ) ? '<h2 class="mainSlider__title">'.( !empty( $aData['sUrl'] ) ? '<a href="'.$aData['sUrl'].'">' : null ).$aData['sTitle'].( !empty( $aData['sUrl'] ) ? '</a>' : null ).'</h2>' : null ).
    ( !empty( $aData['sDescription'] ) ? '<div class="mainSlider__desc">'.$aData['sDescription'].'</div>' : null ).
    
      ( !empty( $aData['sUrl'] ) ? '<a href="'.$aData['sUrl'].'" class="mainSlider__button button button-border button-white">'.$lang['more'].'</a>' : null ).
      
      '</div></div></li>';
}// end function listSlidersView


/**
* Displays skip links
* @return string
*/
function displaySkipLinks( ){
  global $lang;
  return '<nav id="skiplinks" aria-label="skiplinks"><ul><li><a href="#head2">'.$lang['Skip_to_main_menu'].'</a></li><li><a href="#content">'.$lang['Skip_to_content'].'</a></li></ul></nav>';
} // end function displaySkipLinks

/**
* Displays back link
* @return string
*/
function displayBackLink( ){
  if( isset( $_SERVER['HTTP_REFERER'] ) && strstr( $_SERVER['HTTP_REFERER'], dirname( $_SERVER['SCRIPT_NAME'] ) ) ){
    return '<li class="back"><a href="javascript:history.back();"><svg class="icon" transform="rotate(180)"><use xlink:href="#svg-arrowround"></use></svg>'.$GLOBALS['lang']['back'].'</a></li>';
  }
} // end function displayBackLink

/**
* Displays hamburger for menu
* @return string
*/
function displayHamburger( ){
  global $lang;
  ob_start( );
  ?>
  <button class="hamburger hamburger--3dx" type="button">
    <span class="hamburger-box">
      <span class="hamburger-inner"></span>
    </span>
    <span class="hamburger-label"><?php echo $lang['Menu']; ?></span>
  </button>
  <?php
  $sReturn = ob_get_contents( );
  ob_end_clean( );
  return $sReturn;
} // end function displayHamburger

?>