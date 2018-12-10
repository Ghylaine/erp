<?php
$file_path ='C:\Users\zebra\Downloads\fichier.xls';
if(file_exists($file_path)) {


unlink($file_path);
echo 'file deleted';
}
else{
	echo 'file is not deleted';
}

?>