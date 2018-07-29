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
	redirect('confirm.php?data='.data_cloaker('encrypt', $time));
}



if(isset($_GET['data']))
{//start of main conditional

$actual_link = $_SESSION['edit_data'];
$all_column='';//inialize all_column
$tables = $_SESSION['tab_col'];
list($table, $column_ref, $id, $ref) = explode('*', $tables);//separate data into separate values
$result = queryMysql("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='gencrud_database' AND TABLE_NAME='$table'");
	 while($row = mysqli_fetch_array($result)){
	    $all_column .= $row[0].',';
	}
 $column_list = str_getcsv($all_column, ',');//assigned all the csv to an array (array_variable[0])


  //ask for the name of columns that are being edit only
	 $col_label = explode('/', $ref);//column and label
	$columns ='';
	 foreach ($col_label as $cl) {
	 	list($col_ord, $lbl) = explode('|', $cl);
	 	 $columns .= $col_ord.',';
	 }
 $columns = str_getcsv($columns, ',');


   $link = str_replace('http://localhost/dapdap/confirm.php?', '', $_SESSION['edit_data']);//this is the raw value
    $col_values = explode('&', $link);//separate data with &
    $col_num = 0;
           foreach ($col_values as $col_value) {//the loop will be limited to the number of data separated by delimiter
            list($label, $value) = explode('=', $col_value);//each value will then be separated into two variables using the = as delimiter
            $value = str_replace('+',' ',$value);
            $value = rawurldecode($value); 
            $value = linis($value);
            $col_name = $column_list[$columns[$col_num]];
            if(!empty($value)){
            queryMysql("UPDATE $table SET $col_name='$value' WHERE $column_ref=$id");
        }
    $col_num++;
     }
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
