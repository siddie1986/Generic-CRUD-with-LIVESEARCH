<?php
date_default_timezone_set('Asia/Manila');
function queryMysql($query)//this would be your final version do not edit to show and insert strings with Ñ
{   $dbc= mysqli_connect("localhost","root","","gencrud_database");
  mysqli_query($dbc, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

     return $result;
}


class Db {
    private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO('mysql:host=localhost;dbname=gencrud_database', 'root', '', $pdo_options);
      }
      return self::$instance;
    }
  }
 $db = Db::getInstance();
      $req = $db->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");






  class Faculty {
    // we define 3 attributes
    // they are public so that we can access them using $post->first_name directly
    public $faculty_id;
    public $first_name;
    public $last_name;
    public $gender;
    public $civil_status;
    public $bmonth;
    public $bday;
    public $byear;
    public $employee_number;
    public $position;
    public $telephone;
    public $email;
   

    public function __construct($faculty_id,$first_name,$last_name, $gender,$bmonth,$bday,$byear,$employee_number,$telephone,$email) {
    $this->faculty_id = $faculty_id;
    $this->first_name= $first_name;
    $this->last_name = $last_name;
    $this->gender = $gender;
    $this->bmonth = $bmonth;
    $this->bday = $bday;
    $this->byear = $byear;
    $this->employee_number = $employee_number;
    $this->telephone = $telephone;
    $this->email= $email;
    
    }
    
  
  
    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query("SELECT * FROM faculty");

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $teacher) {
        $list[] = new Faculty($teacher['faculty_id'],$teacher['first_name'],$teacher['last_name'],
          $teacher['gender'],$teacher['bmonth'],$teacher['bday'],$teacher['byear'],
    $teacher['employee_number'],$teacher['telephone'],$teacher['email']);
      }

      return $list;
    }
  
    public static function find($faculty_id) {
      $db = Db::getInstance();
      // we make sure $learner_id is an integer
      $faculty_id = intval($faculty_id);
      $req = $db->prepare('SELECT * FROM faculty WHERE faculty_id = :faculty_id');
      // the query was prepared, now we replace :learner_id with our actual $learner_id value
      $req->execute(array('faculty_id' => $faculty_id));
      $teacher = $req->fetch();

      return new Faculty($teacher['faculty_id'],$teacher['first_name'],$teacher['last_name'],
          $teacher['gender'],$teacher['bmonth'],$teacher['bday'],$teacher['byear'],
    $teacher['employee_number'],$teacher['telephone'],$teacher['email']);
    }
  
  }





//// generic form inputs ////////////////////////////////////////////////////////////////////////////

function select_day($label, $sel_value)
{
  $l = exploder("|",$label);
  $label = $l[1];
  $name = $l[0];


  $day = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);

     echo"<div class='item form-group'>".
          "<label class='control-label col-md-12 col-sm-12 col-xs-12' for='$label'>$label</label>".
          "<div class='col-md-12 col-sm-12 col-xs-12'>".
          "<select class='form-control' name='$name'>";

          foreach ($day as $value) {
            if($value == $sel_value){$attr = "selected";}else{$attr = "";}
            echo "<option class='form-control'  $attr value='$value'>$value</option>";
          }


          echo"</div>".
          "</select>".
      "</div>";
  
}

function select_year($label, $range, $selected_value)
{
  
  $l = exploder("|",$label);
  $label = $l[1];
  $name = $l[0];

  $r = exploder(" ",$range);
  $Label = ucwords($label);
     echo"<div class='item form-group'>".
          "<label class='control-label col-md-12 col-sm-12 col-xs-12' for='$label'>$label</label>".
          "<div class='col-md-12 col-sm-12 col-xs-12'>".
          "<select class='form-control' name='$label'>";
          
          for ($num = $r[0]; $num < $r[1]; $num++) { 
            if($num == $selected_value){$attr = "selected";}else{$attr = "";}
            
           echo "<option class='form-control' $attr  value='$num'>$num</option>";
          
        }

          echo"</div>".
          "</select>".
      "</div>";
  
}



function select_month($label, $selected_value)
{ 
  $l = exploder("|",$label);
  $label = $l[1];
  $name = $l[0];

  //$r = exploder(" ",$range);
  $Label = ucwords($label);
     echo"<div class='item form-group'>".
          "<label class='control-label col-md-12 col-sm-12 col-xs-12' for='$label'>$label</label>".
          "<div class='col-md-12 col-sm-12 col-xs-12'>".
          "<select class='form-control' name='$name'>";
          
     $month_array = array(1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 
      10=>"October", 11=>"November", 12=>"December");
          
         foreach ($month_array as $value => $month) {
           if($value == $selected_value){$attr = "selected";}else{$attr = "";}
          echo "<option class='form-control' $attr value='$value'>$month</option>";
         }

          echo"</div>".
          "</select>".
      "</div>";
  
}

function text_input($label, $selected_value)
{
  $l = exploder("|",$label);
  $label = $l[1];
  $name = $l[0];
  if($selected_value == FALSE){$selected_value = "";}
  echo"<div class='item form-group'>".
    "<label class='control-label col-md-12 col-sm-12 col-xs-12' for='$label'>$label</label>".
    "<div class='col-md-12 col-sm-12 col-xs-12'>".
    "<input class='form-control'  name='$name' placeholder='$label' required='required' type='text' value='$selected_value'>".
    "</div>".
    "</div>";
}


function hidden_input($label)
{//label holds data

  $d = exploder(" ",$label);
  $value = $d[1];
  echo"<input class='form-control'  name='$label' type='hidden' value='$value'>";
}





///end of generic form inputs //////////////////////////////////////////////////////////////////////////////////////












/// for deleting /////////////////////////////////////////////////////////////////////////////

function gen_delete($data)
{ //generic data adder

  //list($tables, $colum, $id, $data) = explode(',', $data);

  $dat = exploder("*", $data);

  $t = $dat[0]; $c = $dat[1]; $id = $dat[2]; $data = $dat[3];
   $result = queryMysql("SELECT * FROM $t WHERE $c='$id'");

       if (mysqli_num_rows($result))
    {
      
       $row = mysqli_fetch_row($result );
           $rows = explode('/', $data);//separate data into separate values

          $num = 0;//this is the id of each loop of evry variable for flexibility
           foreach ($rows as $keyvalue) {
            list($value, $label) = explode('|', $keyvalue);//each value will then be separated into two variables using the space as delimiter
            $id = $row[0];
            $link = data_cloaker('encrypt',''.$t.','.$c.','.$id.','.$row[$value]);
            //$row[$value] holds the order of the column in the table 0 means the first column
            $value_name = "balyu".$num;
            $num++;//make it incremented so variable can be serialized like $variable0,$variable1 and so on
          

            
            $val = $row[$value];
           
           echo"<div class='item form-group'>".
                "<label class='control-label col-md-12 col-sm-12 col-xs-12' for='$label'>$label</label>".
               "<div class='col-md-12 col-sm-12 col-xs-12'>".
               "<input class='form-control'  name='$value' placeholder='$label' disabled required='required' type='text' value='$val'>".
               "</div>".
                "</div>";
            
  }
   

    }

}




// for editing   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function gen_edit($data)
{ //generic data adder

  //list($tables, $colum, $id, $data) = explode(',', $data);

  $dat = exploder("*", $data);

  $t = $dat[0]; $c = $dat[1]; $id = $dat[2]; $data = $dat[3];
   $result = queryMysql("SELECT * FROM $t WHERE $c='$id'");

       if (mysqli_num_rows($result))
    {
      
       $row = mysqli_fetch_row($result );
           $rows = explode('/', $data);//separate data into separate values

          $num = 0;//this is the id of each loop of evry variable for flexibility
           foreach ($rows as $keyvalue) {
            list($value, $label) = explode('|', $keyvalue);//each value will then be separated into two variables using the space as delimiter
            $id = $row[0];
            $link = data_cloaker('encrypt',''.$t.','.$c.','.$id.','.$row[$value]);
            //$row[$value] holds the order of the column in the table 0 means the first column
            $value_name = "balyu".$num;
            $num++;//make it incremented so variable can be serialized like $variable0,$variable1 and so on
            
            $y = find_text($label, "Year");
            $m = find_text($label, "Month");
            $d = find_text($label, "Day");

            $label = $value_name."|".$label;
            
            $val = $row[$value];
            if($y == TRUE)
            {
              $st = $row[$value]-40;
              $nd = $row[$value]+40;
              $rge = $st." ".$nd;//range of numbers
              echo select_year($label, $rge, $val);
            }elseif($d == TRUE)
            {
              echo select_day($label, $val);

            }elseif($m == TRUE)
            {
              echo select_month($label, $val);

            }else{

              echo text_input($label, $val);

            }
            
  }
   

    }

}












/// add entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////



function gen_add($data)
{ //generic data adder

  //'encrypt','fac_ed_back,0|hidden id/1|hidden l_id/2|School Year/3|Section/4|Grade Level/5|Section/6|Adviser/7|Status/8|Final Grade/9|School/10|School ID/11|District/12|Division/13|hidden user_id/14|hidden time
   
  $dat = linis($data);
  $dat = exploder("*", $data);

  $t = $dat[0]; $data = $dat[2];
  
           $row = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
           $rows = explode('/', $data);//separate data into separate values

          $num = 0;//this is the id of each loop of evry variable for flexibility
           foreach ($rows as $keyvalue) {
            list($value, $label) = explode('|', $keyvalue);//each value will then be separated into two variables using the space as delimiter
          
            //$link = data_cloaker('encrypt',''.$t.','.$row[$value]);
            //$row[$value] holds the order of the column in the table 0 means the first column
            $value_name = "balyu".$num;
            $num++;//make it incremented so variable can be serialized like $variable0,$variable1 and so on
            
            $y = find_text($label, "Year");
            $m = find_text($label, "Month");
            $d = find_text($label, "Day");
            $h = find_text($label, "hidden");


            $label = $value_name."|".$label;

            $value = FALSE;//set to false so no value is set in the form inputs functions for generic adder
            if($y == TRUE)
            {
              $range = "1960 2018";
              echo select_year($label, $range, $value);
            }elseif($m == TRUE)
            {
              echo select_month($label, $value);

            }elseif($d == TRUE)
            {
              echo select_day($label, $value);

            }elseif($h == TRUE){

              echo hidden_input($label, $value);

            }
            else{

              echo text_input($label, $value);

            }
            
  }
   

    

}





function gen_add_insert($table, $data, $num_val)
{ //first column is not included in the counting
$data = linis($data);//this will save you 2 hours just leave this it will replace single quote to nothingness in linis function

  if($num_val == 3){
    list($v1,$v2) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2')");
    
  }elseif($num_val == 4){
    list($v1,$v2,$v3) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3')");
    
  }elseif($num_val == 5){
    list($v1,$v2,$v3,$v4) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4')");
    
  }elseif($num_val == 6){
    list($v1,$v2,$v3,$v4,$v5) =  explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5')");
    
  }elseif($num_val == 7){
    list($v1,$v2,$v3,$v4,$v5,$v6) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6')");
    
  }elseif($num_val == 8){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7')");
    
  }elseif($num_val == 9){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8')");
    
  }elseif($num_val == 10){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9')");
    
  }elseif($num_val == 11){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10')");  

  }elseif($num_val == 12){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11')"); 

  }elseif($num_val == 13){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12')"); 

  }elseif($num_val == 14){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12,$v13) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12','$v13')");  

  }elseif($num_val == 15){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12,$v13,$v14) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12','$v13','$v14')");  
   echo $data;
  }elseif($num_val == 16){
    list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12,$v13,$v14,$v15) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12','$v13','$v14','$v15')");  

  }else{
     list($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12,$v13,$v14,$v15,$v16) = explode('*', $data);
    queryMysql("INSERT INTO $table VALUES(NULL, '$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12','$v13','$v14','$v15','$v16')"); 
  }


}
//end of CRUD////////////////////////////////////////////////////////////////////////////////////////////


///all the view functions starts here/////////////////////////////////////////////////////////////////////////


  //filter strings
  function linis($var)
{
    $var = strip_tags($var);
    //$var = htmlentities($var);// to insert Ñ
    $var = stripslashes($var);
   $var = str_replace("'", " ",$var);

    return mysql_real_escape_string($var);
}

//filter 
function data_cloaker($action, $string) {
    $output = false;
    $string = linis($string);
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'generic';
    $secret_iv = 'CRUD';
   //tested on 4700 length of string, long strings return an error
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}





function exploder($delimiter, $data)
{
  $list = explode($delimiter, $data);
  return $list;
}

function find_text($whole_text, $sub_text)
{
  $result = strstr($whole_text, $sub_text);
  if($result == FALSE){
    return FALSE;}
    else{return TRUE;
    }
}



function show_row($id, $arg)
{
  
  $result = queryMysql("SELECT * FROM $arg");
    if (mysqli_num_rows($result))
    {
        $row = mysqli_fetch_row($result);
    }else
    {
      $row = FALSE;
    }
            
    
    return $row;
}




  //redirecting
function  redirect($page  = 'index.php')  {


$url  = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

  $url  = rtrim($url,  '/\\');


  $url  .=  '/' . $page;

  //  Redirect  the  user:
header("Location:  $url");
exit();  //  Quit  the  script.

} 
 

function show_one($id)
{   $faculty = Faculty::find($id);
    $view = "show_profile|$id|0";//the 3rd argument may hold another value for function with 2 arguments 
                                 //this will be processed in ajax/generic.php
                                  //javascript functions are in includes/footer.php
    echo"<tr>".
          "<td>".$faculty->first_name." ".$faculty->last_name."</td>".
          "<td>".$faculty->gender."</td>".
          "<td>".$faculty->bmonth."-".$faculty->bday."-".$faculty->byear."</td>".
          "<td>".$faculty->employee_number."</td>".
          "<td>".$faculty->telephone."</td>".
          "<td>".$faculty->email."</td>".
           "<td>";?>
            <button type='button' class='btn btn-default btn-xs'  onclick="send_controller('show_profile|<?php echo $id;?>|0')">View</button>
            <?php
            echo"</td>".
          "</tr>";
}


function show_all()
{ 
  ?>
  <div class='table-responsive'>
        <table class='table table-striped table-hover'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Gender</th>
              <th>Birthday</th>
              <th>Employee Number</th>
              <th>Telephone</th>
              <th>Email</th>
              <th>Options</th>
            </tr>
         </thead>
          <tbody>
  <?php

  $faculties = Faculty::all();
  echo"<div id='replacement-page2'>";//start the replacement page
  foreach ($faculties as $faculty) {
    show_one($faculty->faculty_id);
  }
  echo "</div>";//end of replacement page


  ?>
          </tbody>
        </table>
      </div>

<?php

}



//basic functions for viewing data


function search_this($searched_user)
 { //$id = logged user $searched_user = keyword in searched box
  ?>
  <div class='table-responsive'>
        <table class='table table-striped table-hover'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Gender</th>
              <th>Birthday</th>
              <th>Employee Number</th>
              <th>Telephone</th>
              <th>Email</th>
              <th>Options</th>
            </tr>
         </thead>
          <tbody>
  <?php



   $result = queryMysql("SELECT * FROM faculty WHERE first_name like '%$searched_user%' OR last_name like '%$searched_user%' OR  employee_number like '%$searched_user%'");
   $count = mysqli_num_rows($result);


   if($count > 0){echo "<p class='text-warning'>Found ".$count. " result/s.</p>";}


   while($row = mysqli_fetch_row($result))
   {   
       show_one($row[0]);
      
   }

   if(!mysqli_num_rows($result))
   {
      echo "<p class='text-danger'>No result found for your query.</p>";
           
   }
     ?>
          </tbody>
        </table>
      </div>

<?php
 }




function show_profile($id)
{

$faculty = Faculty::find($id);
?>
<div class="row" style="margin:0px;"><!-- row starts -->
  <div class="col-lg-12"><!-- /.col-lg-12 starts-->
      <div class="panel panel-default"><!-- /.panel starts-->
        <div class="panel-heading">
          <strong>Basic Information</strong>
        </div>
    <div class="panel-body"><!-- /panel body starts-->
      <div class='col-lg-2'><!-- /.col-lg-2 starts -->
          <?php
         
          $fi = $faculty->faculty_id;//faculty_id
          $path= "../images/$fi.jpg";
          if(!file_exists($path)){//
            $sh_img="default";
          }else{
            $sh_img=$fi;
          }

          echo"<img class='img-responsive'  src='images/$sh_img.jpg' alt='full_name' style='width:100%;'>";
          echo "<h4>".strtoupper($faculty->first_name." ".$faculty->last_name)."</h4>";
          ?>

          <button class="btn btn-success btn-sm" onclick="send_controller('show_all|<?php echo $id;?>|0')">
                  View All
              </button>

      </div><!-- /.col-lg-2 ends -->
             

       <div class='col-lg-10'><!-- col-lg-10 -->
          <div class="" role="tabpanel" data-example-id="togglable-tabs"><!--tabs options start here -->
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active" onclick="send_controller2('faculty_personal|<?php echo $id.'|a';?>');">
                <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Personal</a>
              </li>
              <li role="presentation" onclick="send_controller2('faculty_eligibility|<?php echo $id.'|a';?>');">
                <a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Eligibility</a>
              </li>
              <li role="presentation" onclick="send_controller2('faculty_education|<?php echo $id.'|a';?>');">
                <a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Education</a>
              </li>
              <li role="presentation"  onclick="send_controller2('faculty_employment|<?php echo $id.'|a';?>');">
                <a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Employment</a>
              </li>
              <li role="presentation"  onclick="send_controller2('faculty_children|<?php echo $id.'|a';?>');">
                <a href="#tab_content5" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Children</a>
              </li>
            </ul>
            
            <div id="replacement-page2"><!--this is where the returned values for tab -->
            <?php faculty_personal($id);?>
            </div><!--returned values for tabs ends -->
          </div><!--tabs options ends here -->
        </div><!-- col-lg-10 ends-->
      </div><!-- panel body ends-->
    </div><!-- /panel ends-->
  </div><!-- /.col-lg-12 ends-->
</div><!-- row ends here fuck-->
<?php
}




function faculty_employment($id){
  ?> 
    <div class='table-responsive'>
        <table class='table table-striped'>
          <thead>
            <tr>
              <th>Descrition</th>
              <th>Position</th>
              <th>Date</th>
              <th>Employee Number</th>
              <th>Employer</th>
              <th>Government (Y/N)</th>
              <th class='text-center'>Sallary</th>
              <th class='text-center'>Sallary Grade</th>
              <th>Status</th>
              <th>Options</th>
            </tr>
         </thead>
          <tbody>
<?php

    $add_link = data_cloaker('encrypt','fac_employ_back*13*1|hidden '.$id.'/2|Work Description/3|Date Started/4|Date Ended/5|Employer/6|Employer Address/7|Position/8|Employee Number/9|Sallary Grade/10|Employment Status/11|Sallary/12|Government');
    $add = "gen_add.php?ref=".$add_link;
    
    $result = queryMysql("SELECT * FROM fac_employ_back WHERE faculty_id=$id");
      while ($row = mysqli_fetch_row($result))
          { 

            $link = data_cloaker('encrypt','fac_employ_back*employback_id*'.$row[0].'*2|Work Description/7|Position/3|Date Started/4|Date Ended/5|Employer/6|Employer Address/8|Employee Number/9|Sallary Grade/10|Employment Status/11|Sallary/12|Government (Yes Or No)');
            
            $edit = "edit.php?ref=".$link;
            //for edit function (encrypt, table, column, id, column_number_array|label/column_number_array|label)
            $delete = "delete.php?ref=".$link;


            echo"<tr>".
              "<td>".$row[2]."</td>".
              "<td>".$row[7]."</td>".
              "<td>".$row[3]." to ".$row[4]."</td>".
              "<td>".$row[8]."</td>".
              "<td>".$row[5]."</td>".
              "<td>".$row[12]."</td>".
              "<td class='text-center'>".$row[11]."</td>".
              "<td class='text-center'>".$row[9]."</td>".
              "<td>".$row[10]."</td>".
               "<td>"."<div class='btn-group pull-right'>".
                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>Options 
                </button>".
                "<ul role='menu' class='dropdown-menu slidedown' style='padding:10px;'>".
                  "<li onclick="."new_tab('$edit')"."><p class='pointer'><i class='fa fa-edit'></i> Edit</p></li>".
                  "<li onclick="."new_tab('$delete')"."><p class='pointer'><i class='fa fa-remove'></i> Delete</p></li>".
                "</ul>".
              "</div>"."</td>".
              "</tr>";
          }
          
          if(!mysqli_num_rows($result)){
              echo"<tr class='text-warning'>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "</tr>";
              }
?>
          </tbody>
        </table>
        <button class="btn btn-primary btn-sm" onclick="new_tab('<?php echo $add;?>')">
            Add Entry
        </button>
      </div>

<?php
}





function faculty_education($id){
?> 
    <div class='table-responsive'>
        <table class='table table-striped'>
          <thead>
            <tr>
              <th>Level</th>
              <th>School</th>
              <th>Course</th>
              <th>Period</th>
              <th>Level Earned</th>
              <th>Year Graduated</th>
              <th>Award Received</th>
              <th>Options</th>
            </tr>
         </thead>
          <tbody>
<?php

        $add_link = data_cloaker('encrypt','fac_ed_back*10*1|hidden '.$id.'/2|Level/3|School/4|Course/5|Year Started/6|Year Ended/7|Level Earned/8|Year Graduated/9|Award Received');

        $add = "gen_add.php?ref=".$add_link;
    $result = queryMysql("SELECT * FROM fac_ed_back WHERE faculty_id=$id ORDER BY edback_id DESC");
      while ($row = mysqli_fetch_row($result))
          { 
            $link = data_cloaker('encrypt','fac_ed_back*edback_id*'.$row[0].'*2|Level/3|School/4|Course/5|Year Started/6|Year Ended/7|Level Earned/8|Year Graduated/9|Award Received');
            
            $edit = "edit.php?ref=".$link;
            $delete = "delete.php?ref=".$link;
            echo"<tr>".
              "<td>".$row[2]."</td>".
              "<td>".$row[3]."</td>".
              "<td>".$row[4]."</td>".
              "<td>".$row[5].' to '.$row[6]."</td>".
              "<td>".$row[7]."</td>".
              "<td>".$row[8]."</td>".
              "<td>".$row[9]."</td>".
              "<td>"."<div class='btn-group pull-right'>".
                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>Options 
                </button>".
                "<ul role='menu' class='dropdown-menu slidedown' style='padding:10px;'>".
                  "<li onclick="."new_tab('$edit')"."><p class='pointer'><i class='fa fa-edit'></i> Edit</p></li>".
                  "<li onclick="."new_tab('$delete')"."><p class='pointer'><i class='fa fa-remove'></i> Delete</p></li>".
                "</ul>".
              "</div>"."</td>".
              "</tr>";
          }
          
          if(!mysqli_num_rows($result)){
              echo"<tr class='text-warning'>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "</tr>";
              }

          

?>
          </tbody>
        </table>
                                
              <button class="btn btn-primary btn-sm" onclick="new_tab('<?php echo $add;?>')">
                  Add Entry
              </button>
            

      </div>

<?php
      
}


function faculty_personal($id){
    $faculty = Faculty::find($id);
  
    $link = data_cloaker('encrypt','faculty*faculty_id*'.$id.'*1|First Name/2|Last Name/4|Birth Month/5|Day/6|Year/3|Sex/7|Employeee Number/8|Landline Number/9|Email');
    //coma (,) is not to be used as label


            
    $edit = "edit.php?ref=".$link;//edit link  
    $delete = "delete.php?ref=".$link;//delete link
    
  echo"<div class='panel-body'>".
  "<ul class='list-unstyled user_data'>";
  
  //these are the data
   $fn = $faculty->first_name." ".$faculty->last_name;
   $bday = $faculty->bmonth."/".$faculty->bday."/".$faculty->byear;

    $info_array = array("Full Name"=>$fn, "Date of Birth"=>$bday,"Sex"=>$faculty->gender,"Employee Number"=>$faculty->employee_number,"Telephone"=>$faculty->telephone,"Email"=>strtolower($faculty->email));

    foreach ($info_array as $label => $value) {

      if($value ==""){$value="<span class='text-warning'>Empty</span>";}
      echo "<li><strong>$label: </strong>".$value."</li>";
    }
    echo"</ul>".

    "</div>";
     ?>

              <button class="btn btn-default btn-sm" onclick="new_tab('<?php echo $edit;?>')">
                  Update
              </button>
              <button class="btn btn-danger btn-sm" onclick="new_tab('<?php echo $delete;?>')">
                  Delete
              </button>
              


     <?php
}






function faculty_children($id){
?> 
    <div class='table-responsive'>
        <table class='table table-striped'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Gender</th>
              <th>Birthday</th>
              <th>Remark/s</th>
              <th class='text-right'>Options</th>
            </tr>
         </thead>
          <tbody>
<?php

    //the label is not the name attribute in the form just so you know
    $add_link = data_cloaker('encrypt','fac_children*8*1|hidden '.$id.'/2|First Name/3|Middle Name/4|Last Name/5|Gender/6|Birthday/7|Remarks');
    $add = "gen_add.php?ref=".$add_link;//table, number of columns in the table, reference number and should be hidden, data

    $result = queryMysql("SELECT * FROM fac_children WHERE faculty_id=$id");
      while ($row = mysqli_fetch_row($result))
          { 
            $link = data_cloaker('encrypt','fac_children*child_id*'.$row[0].'*2|First Name/3|Middle Name/4|Last Name/5|Gender/6|Birthday/7|Remarks');
            
            $edit = "edit.php?ref=".$link;
            //for edit function (encrypt, table, column, id, column_number_array|label/column_number_array|label)
            $delete = "delete.php?ref=".$link;

            echo"<tr>".
              "<td>".$row[2]." ".$row[3]." ".$row[4]."</td>".
              "<td>".$row[5]."</td>".
              "<td>".$row[6]."</td>".
              "<td>".$row[7]."</td>".
              "<td>"."<div class='btn-group pull-right'>".
                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>Options 
                </button>".
                "<ul role='menu' class='dropdown-menu slidedown' style='padding:10px;'>".
                  "<li onclick="."new_tab('$edit')"."><p class='pointer'><i class='fa fa-edit'></i> Edit</p></li>".
                  "<li onclick="."new_tab('$delete')"."><p class='pointer'><i class='fa fa-remove'></i> Delete</p></li>".
                "</ul>".
              "</div>"."</td>".
              "</tr>";
          }
          
          if(!mysqli_num_rows($result)){
              echo"<tr class='text-warning'>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".  
                "<td class='center'>Empty</td>".              
                "</tr>";
              }
?>
          </tbody>
        </table>
        <button class="btn btn-primary btn-sm" onclick="new_tab('<?php echo $add;?>')">
            Add Entry
        </button>
      </div>

<?php
}




function faculty_eligibility($id){
?> 
    <div class='table-responsive'>
        <table class='table table-striped'>
          <thead>
            <tr>
              <th>Eligibility</th>
              <th>Rating</th>
              <th>Date of Examination</th>
              <th>Place of Examination</th>
              <th>License Number</th>
              <th>End of Validity</th>
              <th class='text-right'>Options</th>
            </tr>
         </thead>
          <tbody>
<?php

    //the label is not the name attribute in the form just so you know
    $add_link = data_cloaker('encrypt','fac_eligibility*8*1|hidden '.$id.'/2|Eligibility/3|Rating/4|Date of Examination (mm-dd-yyyy)/5|Examination Place/6|License Number/7|End of Validity (mm-dd-yyyy)');
    $add = "gen_add.php?ref=".$add_link;//table, number of columns in the table, reference number and should be hidden, data

    $result = queryMysql("SELECT * FROM fac_eligibility WHERE faculty_id=$id");
      while ($row = mysqli_fetch_row($result))
          { 
            $link = data_cloaker('encrypt','fac_eligibility*elig_id*'.$row[0].'*2|Eligibility/3|Rating/4|Date of Examination (mm-dd-yyyy)/5|Examination Place/6|License Number/7|End of Validity');
            
            $edit = "edit.php?ref=".$link;
            //for edit function (encrypt, table, column, id, column_number_array|label/column_number_array|label)
            $delete = "delete.php?ref=".$link;

            echo"<tr>".
              "<td>".$row[2]."</td>".
              "<td>".$row[3]."</td>".
              "<td>".$row[4]."</td>".
              "<td>".$row[5]."</td>".
              "<td>".$row[6]."</td>".
              "<td>".$row[7]."</td>".
              "<td>"."<div class='btn-group pull-right'>".
                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>Options 
                </button>".
                "<ul role='menu' class='dropdown-menu slidedown' style='padding:10px;'>".
                  "<li onclick="."new_tab('$edit')"."><p class='pointer'><i class='fa fa-edit'></i> Edit</p></li>".
                  "<li onclick="."new_tab('$delete')"."><p class='pointer'><i class='fa fa-remove'></i> Delete</p></li>".
                "</ul>".
              "</div>"."</td>".
              "</tr>";
          }
          
          if(!mysqli_num_rows($result)){
              echo"<tr class='text-warning'>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".
                "<td>Empty</td>".  
                "<td>Empty</td>". 
                "<td>Empty</td>".
                "<td>Empty</td>".             
                "</tr>";
              }
?>
          </tbody>
        </table>
        <button class="btn btn-primary btn-sm" onclick="new_tab('<?php echo $add;?>')">
            Add Entry
        </button>
      </div>

<?php
}


?>