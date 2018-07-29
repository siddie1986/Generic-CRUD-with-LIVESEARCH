<?php
require_once('../crudcon.php');
include('includes/header.php');
if(isset($_GET['ref'])){
	$ref=linis($_GET['ref']);
	$_SESSION['tab_col'] = data_cloaker('decrypt', $ref);//holds the row data (table, column, id, column_number_array|label/column_number_array|label and so on)
	//process it on confirm.php
}else{$ref="";}

$ref = data_cloaker('decrypt', $ref);


?>
<body style='background:white;'>
  <div role="main">

    <div class="row unmarge" style="background:white;">
    
<div class='col-md-1 col-sm-12'></div>
  <div class='col-md-10 col-sm-12'>
    <h1>Delete Entry</h1>
    <form action="gen_delete.php" method="GET">
 
<?php 
 echo "<div class='row unmarge'>".
 "<div class='col-lg-12'>";


  gen_delete($ref);



    echo"</div>";

    //select_day("Birthday", "5");

  ?>

  <div class='item form-group' style='margin:10px;'>
    <button type='submit' style='margin-top:30px;' class='btn btn-danger'>
      Delete
    </button>

    <button  style='margin-top:30px;' class='btn btn-default' onclick="cancel();">
      Cancel
    </button>
    
  </div>
    </form>
    </div>
    <div class='col-md-1 col-sm-12'></div>


    </div>
    </div>
  </body>

<!-- /page content -->

<?php include 'includes/footer.php';?>