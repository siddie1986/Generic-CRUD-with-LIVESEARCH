<?php
require_once('../skul_database.php');
include('includes/header.php');
//if admin is loggedin, he can add anyone to any section
if(isset($_GET['ref']) AND $access==1){//ref here is the sec_id in the faulty table
  $ref= data_cloaker('decrypt', linis($_GET['ref']));
}else{$ref=$faculty_id;}

$s = show_row($ref, "lores_section WHERE sec_adviser_id=$ref");


?>
<body style='background:white;'>
    <div role="main" >
    <div class="row unmarge" style="background:white;">   
<div class='col-md-1 col-sm-12'></div>
  <div class='col-md-10 col-sm-12'>
    <h1>Enrol Learner</h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo strtoupper($s[2]." ".$s[1]); ?></strong>
            </div>
            <div class="panel-body"><!-- panel start -->
                <form action="add.php" method="GET" role="form">
                    <div class="col-lg-4"><!-- divide the page into two this is the lef -->
                        <div class="form-group input-group">
                            <input type="text" class="form-control" id="search_value" placeholder="Search user">
                            <input type="hidden" class="form-control" id="user" value="<?php  echo $ref;?>"><!-- holds the value of the logged user -->
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <div class="row"><!-- start a new full width div inside the left div -->
                            <div class="col-lg-12" id="replacement-page">

                            </div>
                        </div>
                    </div><!-- end of left div -->
                    <div class="col-lg-8"><!-- start of right div -->
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="alert alert-info">There are 555 pupils eligible for enrolment for this level.</p>
                            </div>
                            <div class="col-lg-12" id="result">
                                
                            </div>
                        </div>
                    </div><!-- end of the right div-->
                </form>
            </div><!-- panel end -->
        </div>
        <button  style='margin-top:30px;' class='btn btn-default' onclick="cancel();">
      Close
    </button>
    </div>
    <div class='col-md-1 col-sm-12'></div>
    </div>
    </div>
</body>

<!-- /page content -->

<?php include 'includes/footer.php';?>