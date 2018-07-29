

</div><!-- end id wrapper -->
   <script src="assets/js/jquery.js"></script>
  <script>
    
    var XMLHttpRequestObject = false;

  if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
              } else if (window.ActiveXObject) {
                XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
              }
  </script>
  

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.js"></script>


    
    <!-- Custom Theme JavaScript -->
    <script src="assets/js/sb-admin-2.js"></script>
  
   
  <script>


    /*searching a user*/
  $(document).ready(function() {
  $('#search_value').keyup(function() {
    var search = $('#search_value').val();
    var user = $('#user').val();
    var value = search;
    

    $.ajax({
      type: 'post',
      url: 'ajax/search.php',
      data: 'post=' + value,
      success: function(r) {
        $('#replacement-page').html(r);
      }
    });
  });
});

  


     function send_controller(controller)

  { 
    var div_id = document.getElementById("replacement-page");
    div_id.innerHTML = "<div style='position:absolute;margin-top:50px;'><p>LOADING...</p></div>";
    if(XMLHttpRequestObject) 
      { XMLHttpRequestObject.open("POST", "ajax/generic.php");
        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        XMLHttpRequestObject.onreadystatechange = function()
        {   

          if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
            {
              
              var returned_data = XMLHttpRequestObject.responseText;
              div_id.innerHTML = returned_data;   
            }
        }
      
      var mydata= controller;
      XMLHttpRequestObject.send("mydata=" + mydata);//send to the script
      
        
    }
  }


  function send_controller2(controller)

  { 
    var div_id = document.getElementById("replacement-page2");
    div_id.innerHTML = "<div style='position:absolute;margin-top:50px;'><p>LOADING...</p></div>";
    if(XMLHttpRequestObject) 
      { XMLHttpRequestObject.open("POST", "ajax/generic.php");
        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        XMLHttpRequestObject.onreadystatechange = function()
        {   

          if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
            {
              
              var returned_data = XMLHttpRequestObject.responseText;
              div_id.innerHTML = returned_data;   
            }
        }
      
      var mydata= controller;
      XMLHttpRequestObject.send("mydata=" + mydata);//send to the script
      
        
    }
  }


  function send_controller3(controller)

  { 
    var div_id = document.getElementById("replacement-page3");
    div_id.innerHTML = "<div style='position:absolute;margin-top:50px;'><p>LOADING...</p></div>";
    if(XMLHttpRequestObject) 
      { XMLHttpRequestObject.open("POST", "ajax/generic.php");
        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        XMLHttpRequestObject.onreadystatechange = function()
        {   

          if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
            {
              
              var returned_data = XMLHttpRequestObject.responseText;
              div_id.innerHTML = returned_data;   
            }
        }
      
      var mydata= controller;
      XMLHttpRequestObject.send("mydata=" + mydata);//send to the script
      
        
    }
  }

function new_tab(lnk)
  {
       
     window.open(lnk, "new_tab", "width=1300, height=650");


  }

  


function cancel() { window.close(); }



  </script>


  </body>
<html>