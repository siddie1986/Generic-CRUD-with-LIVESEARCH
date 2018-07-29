<?php
	if (isset($_GET['doc_id'])){
		$dc= $_GET['doc_id'];
		$docu = "docu";//the folder for learner's documents
	}

	elseif(isset($_GET['fd_id'])){
		$dc= $_GET['fd_id'];
		$docu = "facdocu";//the folder for faculty's documents
	}
	else{
		$dc="";
	}
if(file_exists("uploads/$docu/$dc.jpg")){echo"<img id='$dc' src='uploads/$docu/$dc.jpg' />";}else{echo"<img src='uploads/$docu/default.jpg'/>";}
?>

