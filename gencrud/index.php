<?php
include 'includes/header.php';
$add = data_cloaker('encrypt','faculty*10*1|First Name/2|Last Name/4|Birth Month/5|Day/6|Year/3|Sex/7|Employeee Number/8|Landline Number/9|Email');
$add = "gen_add.php?ref=".$add;


 ?>

   <div class="row unmarge" style="background:#ffffff;min-height:700px;">

      <div class="col-lg-2"> 
      </div>
      <div class="col-lg-8">
          <h1 class="page-header">Generic CRUD</h1>
           <div class="panel-body"><!-- panel start -->
                <form action="add.php" method="GET" role="form">
                    <div class="col-lg-4"><!-- divide the page into two this is the lef -->
                        <div class="form-group input-group">
                            <input type="text" class="form-control" id="search_value" placeholder="Search employee"> 
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                    </div>

                    <div class="col-lg-2">
                      <p class="btn btn-sm btn-primary" onclick="new_tab('<?php echo $add;?>')">Add Faculty</p>
                    </div>
                </form>
            </div><!-- panel end -->


          <div class="row" id="replacement-page">
            <?php 
              show_all();//this will be the default function showing all the faculty members
            ?>
          </div>
      </div><!-- /.col-lg-12 -->
      <div class="col-lg-2"> 
      </div>
   </div>
   </div> <!-- /page-wrapper started in includes/header.php-->
    <?php include "includes/footer.php"; ?>
