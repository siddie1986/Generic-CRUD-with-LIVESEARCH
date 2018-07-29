<?php 
require_once('../../crudcon.php');
  if(isset($_POST['mydata']))
    {
    
     $mydata = linis($_POST['mydata']);
  
        list($func_name, $id, $all) = explode('|', $mydata);
        //name of function, the id and if it has an argument function or not
        if($all > 0){//if all is 1, then meaning, get all the data which means no argument function is set
          $func_name($id, $all);
        }
        elseif($all==1){//if all is 1, then meaning, get all the data which means no argument function is set
          $func_name();
        }
        elseif(!is_numeric($all))
        {//if second argument is not a number, do this
          $func_name($id, $all);//$all should be a string for this condition
        }
        else{//if 0, then get its ID to reference the specific data
          $func_name($id);
        }
      }
     
    elseif (isset($_POST['optiondata'])) {

      echo $_POST['optiondata'];
      
      
    }

    
  
?>
