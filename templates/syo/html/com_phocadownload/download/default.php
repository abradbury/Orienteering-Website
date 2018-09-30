<?php
defined('_JEXEC') or die('Restricted access'); 

echo '<div id="phoca-dl-download-box" class="pd-download-view'.$this->t['p']->get( 'pageclass_sfx' ).'" >';
echo '<div class="pd-download">';

if ( $this->t['p']->get( 'show_page_heading' ) ) { 
	echo '<h1>'. $this->escape($this->t['p']->get('page_heading')) . '</h1>';
}
?>

<?php
if ($this->t['found'] == 1) {
	if(isset($this->file[0]->id) && (int)$this->file[0]->id > 0 && isset($this->file[0]->token) && $this->file[0]->token != '') {
		
		$v = $this->file[0];
		$downloadLink = PhocaDownloadRoute::getDownloadRoute((int)$v->id, (int)$v->catid, $v->token);
		$l = new PhocaDownloadLayout();
		
		$pdTitle = '';
		if ($v->title != '') {
			$pdTitle .= '<div class="pd-title">'.$v->title.'</div>';
		}
				
		$pdImage = '';
		if ($v->image_download != '') {
			$pdImage .= '<div class="pd-image">'.$l->getImageDownload($v->image_download).'</div>';		
		}
				
		if ($v->filename != '') {
			$imageFileName = $l->getImageFileName($v->image_filename, $v->filename);
			
			$pdFile = '<div class="col-sm-8">';
			if ($this->t['filename_or_name'] == 'filenametitle') {
				$pdFile .= '<div class="pd-title">'. $v->title . '</div>';
			}
			
			$pdFile .= '<div class="pd-filename">'. $imageFileName['filenamethumb']
				. '<div class="pd-document'.$this->t['file_icon_size'].'" '
				. $imageFileName['filenamestyle'].'>';
			
			$pdFile .= '<div class="pd-float">';
			$pdFile .= $l->getName($v->title, $v->filename);
			$pdFile .= '</div>';
			
			$pdFile .= PhocaDownloadRenderFront::displayNewIcon($v->date, $this->t['displaynew']);
			$pdFile .= PhocaDownloadRenderFront::displayHotIcon($v->hits, $this->t['displayhot']);
			
			//Specific icons
			if (isset($v->image_filename_spec1) && $v->image_filename_spec1 != '') {
				$pdFile .= '<div class="pd-float">'.$l->getImageDownload($v->image_filename_spec1).'</div>';
			} 
			if (isset($v->image_filename_spec2) && $v->image_filename_spec2 != '') {
				$pdFile .= '<div class="pd-float">'.$l->getImageDownload($v->image_filename_spec2).'</div>';
			} 
			
			$pdFile .= '</div></div></div>' . "\n";
		}
		echo '<div class="pd-downloadbox-direct row">'
		.$pdFile
		.'<div class="col-sm-4 plg_system_eprivacy_accepted">'
		.'<a class="btn btn-success btn-block" href="'.JRoute::_($downloadLink).'">'.JText::_('COM_PHOCADOWNLOAD_DOWNLOAD_FILE').'</a>'
		.'</div><div class="col-sm-4">{module 217}</div>'
		.'</div>';
		
	}
} else {
	echo '<div class="pd-not-found">'.JText::_('COM_PHOCADOWNLOAD_FILE_NOT_FOUND').'</div>';
}

echo '</div></div><div class="pd-cb">&nbsp;</div>'. $this->t['pw'];
?>