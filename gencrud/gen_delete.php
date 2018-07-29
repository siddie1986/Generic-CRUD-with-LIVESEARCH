<?php
include('includes/header.php');
if(isset($_GET['ref'])){$ref=linis($_GET['ref']);}else{$ref="";}
if(isset($_GET['act'])){$act=linis($_GET['act']);}else{$act="";}
$ref = data_cloaker('decrypt', $ref);
$time = time();
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(!isset($_GET['data'])){
	$_SESSION['edit_data']=$actual_link;//this is the data
	$actual_link = $_SESSION['edit_data'];
}
if(!isset($_GET['data'])){
	$actual_link = str_split($actual_link, 20);
	redirect('gen_delete.php?data='.data_cloaker('encrypt', $time));
}
if(isset($_GET['data']))
{//start of main conditional


//fac_ed_back,edback_id,115,2|Level/3|School/4|Course/5|Year Started/6|Year Ended/7|Level Earned/8|Year Graduated/9|Award Received the data to be delete
$d = exploder("*", $_SESSION['tab_col']);
$q = "DELETE FROM ".$d[0]." WHERE ".$d[1]."=".$d[2];
queryMysql($q);

 }//end of main conditional
 
?>
<!-- /page content -->
<script src="assets/js/jquery.js"></script>
<body style='background:white;height:1500px;width:1500px;'  onload="update_timer('2000');"><p style="margin:20px;">Please wait...</p></body>

<script>
	function cancel() { window.close(); }


    /*1000 is equal to 1 second*/ 
     function update_timer(tym) {
             setTimeout(cancel, tym);
            }

</script>
