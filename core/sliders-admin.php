<?php
/**
* Save slider data
* @return int
* @param array $aForm
*/
function saveSlider( $aForm ){
  global $config;
  
  $oSql = Sql::getInstance( );
  $oIJ = ImageJobs::getInstance( );

  $aForm = changeMassTxt( $aForm, 'ndnl', Array( 'sDescription', 'nds ndnl' ) );

  if( !empty( $_FILES['aFile']['name'] ) && $oIJ->checkCorrectFile( $_FILES['aFile']['name'], $config['allowed_image_extensions'] ) )
    $aForm['sFileName'] = $oIJ->uploadFile( $_FILES['aFile'], 'files/' );
  elseif( !empty( $aForm['sFileNameOnServer'] ) && $oIJ->checkCorrectFile( $aForm['sFileNameOnServer'], $config['allowed_image_extensions'] ) && is_file( 'files/'.$aForm['sFileNameOnServer'] ) ) 
    $aForm['sFileName'] = $aForm['sFileNameOnServer'];

  if( !empty( $aForm['sFileName'] ) && isset( $config['slider_srcset'] ) ){
    $aNameExt = $oIJ->throwNameExtOfFile( $aForm['sFileName'] );
    $aImgSize = $oIJ->throwImgSize( 'files/'.$aForm['sFileName'] );

    foreach( $config['slider_srcset'] as $iSize ){
      $iSize = trim( $iSize );
      if( is_numeric( $iSize ) && isset( $aImgSize ) && $aImgSize['width'] > $iSize ){
        if( !is_file( 'files/'.$aNameExt[0].'_srcset_'.$iSize.'.'.$aNameExt[1] ) ){
          $oIJ->setThumbSize( $iSize );
          $oIJ->createThumb( 'files/'.$aForm['sFileName'], 'files/', $aNameExt[0].'_srcset_'.$iSize.'.'.$aNameExt[1] );
        }
      }
    } // end foreach
  }

  if( isset( $aForm['iSlider'] ) && is_numeric( $aForm['iSlider'] ) ){
    $oSql->update( 'sliders', $aForm, Array( 'iSlider' => $aForm['iSlider'] ), true );
  }
  else{
    $aForm['sLang'] = $config['language'];
    unset( $aForm['iSlider'] );
    $aForm['iSlider'] = $oSql->insert( 'sliders', $aForm, true );
  }

  return $aForm['iSlider'];
} // end function saveSlider

/**
* Returns slider data
* @return array
* @param int $iSlider
*/
function throwSlider( $iSlider ){
  $oSql = Sql::getInstance( );
  return $oSql->throwAll( 'SELECT * FROM sliders WHERE iSlider = "'.$iSlider.'"' );
} // end function throwSlider

/**
* List sliders
* @return string
*/
function listSlidersAdmin( ){
  global $lang;

  $oSql = Sql::getInstance( );
  $oQuery = $oSql->getQuery( 'SELECT * FROM sliders WHERE sLang = "'.$GLOBALS['config']['language'].'" ORDER BY iPosition ASC' );
  $i = 0;
  $content = null;
  while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
    $content .= '<tr class="l'.( ( ++$i % 2 ) ? 0: 1 ).'"><td class="image"><div class="d-flex"><a href="?p=sliders-form&amp;iSlider='.$aData['iSlider'].'"><img src="files/'.$aData['sFileName'].'" alt="" style="width:90%; max-width:200px" /></a><div class="more-info"><h5>'.$aData['sTitle'].'</h5><p>'.$aData['sDescription'].'</p><p class="filename muted mt-1"><small>'.$aData['sFileName'].'</small></p></div></td><td class="position"><input type="text" name="aPositions['.$aData['iSlider'].']" value="'.$aData['iPosition'].'" class="numeric" size="3" maxlength="4" /></td><td class="options">
    <a href="?p=sliders-form&amp;iSlider='.$aData['iSlider'].'" class="button button-xs button-border"><img src="templates/admin/img/edit.svg"></a><a href="?p=sliders&amp;iItemDelete='.$aData['iSlider'].'" onclick="return del( )" class="button button-xs button-danger ml-1"><img src="templates/admin/img/delete.svg"></a></td></tr>';
  } // end while

  return $content;
} // end function listSlidersAdmin

/**
* Deletes slider
* @return void
* @param int $iSlider
*/
function deleteSlider( $iSlider ){
  global $config;

  $oSql = Sql::getInstance( );
  $oIJ = ImageJobs::getInstance( );
  $aData = throwSlider( $iSlider );

  if( isset( $aData['iSlider'] ) ){
    $oSql->query( 'DELETE FROM sliders WHERE iSlider = "'.$iSlider.'" ' );

    if( isset( $config['delete_unused_files'] ) ){
      if( !empty( $aData['sFileName'] ) ){
       
        $aDeleteFiles[$aData['sFileName']] = true;

        foreach( $config['slider_srcset'] as $iSize ){
          $iSize = trim( $iSize );
          $aNameExt = $oIJ->throwNameExtOfFile( $aData['sFileName'] );
          $sFileNameSrcSet = $aNameExt[0].'_srcset_'.$iSize.'.'.$aNameExt[1];
          if( is_file( 'files/'.$sFileNameSrcSet ) ){
            $aDeleteFiles[$sFileNameSrcSet] = true;
          }
        } // end foreach

        $oFile = FilesAdmin::getInstance( );
        foreach( $aDeleteFiles as $sFileName => $bValue ){
          $oFile->deleteFilesFromDirs( $sFileName );
        } // end foreach
        //
      }
    }
  }
} // end function deleteSlider

/**
* Saves slider's position and status
* @return void
* @param array $aForm
*/
function saveSliders( $aForm ){
    global $config;

    if( isset( $aForm['aPositions'] ) && is_array( $aForm['aPositions'] ) ){
      
      $oSql = Sql::getInstance( );
      $oQuery = $oSql->getQuery( 'SELECT iSlider, iPosition FROM sliders WHERE sLang = "'.$config['language'].'"' );
      while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
        if( isset( $aForm['aPositions'][$aData['iSlider']] ) && $aForm['aPositions'][$aData['iSlider']] != $aData['iPosition'] ){
          $aChanged[$aData['iSlider']] = (int) $aForm['aPositions'][$aData['iSlider']];
        }
      } // end while

      if( isset( $aChanged ) ){
        foreach( $aChanged as $iSlider => $iPosition ){
          $oSql->query( 'UPDATE sliders SET iPosition = '.$iPosition.' WHERE iSlider = '.$iSlider );
        } // end foreach
      }
    }
} // end function saveSliders

/**
* Returns a list of sliders files in form of a HTML select
* @return string
* @param string $sFileSelect
*/
function listSlidersFilesAdmin( $sFileSelect = null ){ 
  $content = null; 
  $oSql = Sql::getInstance( ); 
  $oQuery = $oSql->getQuery( 'SELECT sFileName FROM sliders GROUP BY sFileName ORDER BY sFileName ASC' ); 
  while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){ 
    $content .= '<option value="'.$aData['sFileName'].'"'.( ( isset( $sFileSelect ) && $sFileSelect == $aData['sFileName'] ) ? ' selected="selected"' : null ).'>'.$aData['sFileName'].'</option>'; 
  } // end while 
  return $content; 
} // end function listSlidersFilesAdmin 
?>