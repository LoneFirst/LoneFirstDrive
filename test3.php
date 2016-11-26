<?php
function getDN($var){
	if(strrpos($var,'/') == strlen($var)) {
		return [$var,];
	}
	return [substr($var,0,strrpos($var,'/')+1),substr($var,-strrpos($var,'/'))];
}

$a = getDN('asdasd/asdasd/asdasd.asdasd');
echo $a[0].'</br>'.$a[1];