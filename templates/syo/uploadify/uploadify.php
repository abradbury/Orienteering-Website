<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$preTargetFolder = '/home/j14sout/public_html/beta';
$targetFolder = '/event'; // Relative to the root

// Paths for localhost testing
//$preTargetFolder = '/Applications/XAMPP/xamppfiles/htdocs';
//$targetFolder = '/syo/event'; // Relative to the root

if (!empty($_FILES)) {
	
	$eventVenue = $_POST['eventVenue'];
	$eventDate = $_POST['eventDate'];
	$documentType = $_POST['fileType'];
	
	$targetFolder = $targetFolder.'/'.$eventDate.'-'.$eventVenue;

	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// If the folder does not exist, create one
	if(!file_exists($targetPath))
	{
		mkdir(str_replace('//','/',$targetPath), 0755, true);
	}
	
	// Validate the file type
	$fileTypes = array('pdf', 'jpg', 'jpeg', 'txt', 'rtf', 'doc', 'docx', 'xlsx', 'xls', 'htm', 'html'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	// If the 'extension' file part is in the fileTypes array
	if (in_array($fileParts['extension'],$fileTypes)) 
	{
		$existingVerions = glob(rtrim($targetPath,'/') . '/' . $documentType . '_v[0-9].' . $fileParts['extension']);
		$newFile =  $targetFolder . '/' . $documentType . '_v1.' . $fileParts['extension'];
				
		// If there are no existing versions
		if(!$existingVerions) {
			move_uploaded_file($tempFile,$targetFile);
			rename($preTargetFolder . $targetFolder . '/' . $_FILES['Filedata']['name'], $preTargetFolder . $newFile);
		}
		// If there are existing versions
		else
		{
			// Splits into '/home/j14sout/../flyer_v3' and 'pdf'
			list($name, $ext) = explode('.', end($existingVerions));

			// Splits into '/home/j14sout/../flyer' and '3'
			list($basename, $index) = explode('_v', $name);
			
			$index++; // increment the index
			$basename = substr($basename,37);

			// TODO: Change 37 - hardcoded based specific URL

			$newFile = $basename . '_v' . $index . '.' . $ext;
			move_uploaded_file($tempFile,$targetFile);
			rename($preTargetFolder . $targetFolder . '/' . $_FILES['Filedata']['name'], $preTargetFolder . $newFile);
		}
		echo $newFile;		// E.g. /home/j14sout/../2011-11-01-limb-valley/flyer_v4.pdf
	} else {
		echo "File extension not allowed";
		return false;
	}
} else {
	echo "FILES empty";
	return false;
}

?>