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
	redirect('gen_adder.php?data='.data_cloaker('encrypt', $time));
}


$link = str_replace('http://localhost/dapdap/gen_adder.php?', '', $_SESSION['edit_data']);//this is the raw value
$col_values = explode('&', $link);//separate data with &


    $columns ="";
     foreach ($col_values as $column_and_value) {
        $val = exploder('=', $column_and_value);
         $columns .= linis($val[1])."*";
         
         
     }
     
   $len = strlen($columns);
   $len = $len-1;
   $d = $len*2;
   $values = substr($columns, -$d, $len);
   $values = str_replace('+',' ',$values);
   $values = rawurldecode($values); 
    

   $f = exploder("*",$_SESSION['tab_col']);//the table name
   gen_add_insert($f[0], $values, $f[1]);//table, data, number of columns in the table




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
