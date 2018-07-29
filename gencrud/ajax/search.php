<?php
require('../../crudcon.php');
$time =time();
$post_content = linis($_POST['post']);
$l = strlen($post_content);
if( $l > 2){
	search_this($post_content);
}
else{
	echo"";
}
if(empty($post_content)){
	show_all();
}


?>

















