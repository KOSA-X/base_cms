<?php

if ($aData['sPanel'] != 0 ){  
    
    if($aData['iMenu'] == 2 || $aData['iPage'] == $config['shop_page']){
 
        // SKLEP ONLINE
        
        echo '<div class="mainPage__column">';
        
        echo listMenu(array(
            'sql' => 'iPageParent=0 AND iMenu=2', 
            'title' => '<img src="'.ICONS.'shop.svg" alt="Sklep" class="icon invert"><a href="'.getUrl($config['shop_page']).'" class="back">Sklep online</a>',
            'toggle' => TRUE,
            'footer' => '<nav>'.cartIcon().'</nav>',
        ));
        
        echo '</div>';
        
    }else{ 
        // STANDARD
        echo '<div class="mainPage__column">';
          if(isset($aData['iPageParent']) && $aData['iPageParent'] != 0){
              $title_page = $oPage->throwPage( $aData['iPageParent'] );
              $menu_name = "<a href='".$oPage->aPages[$aData['iPageParent']]['sLinkName']."' class='back'>".$title_page['sName']."</a>";
              echo $oPage->listMenu($menu_id, array('title' => $menu_name));
          }
        echo '</div>';
    }
 }

     