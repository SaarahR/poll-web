<?php
// Initialize the session
require_once 'config.php';
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
  header("location: login.php");
   
}
else {
    
   $sid = $_SESSION['userid']; 
    
    $sql = "Select username from users where id='$sid';";
                            
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
        $sname= $row['username'];
    }
}
}
?>


<html>  
      <head>  
           <title>Create Poll</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <style type="text/css">
             body{ font: 14px sans-serif; color: white; ;text-align: center; margin-left: 10%;
              margin-right: 10%;
              margin-top: 5%;
              background: url(../img/bg-pattern.png),linear-gradient(to left,#7b4397,#dc2430); }
             .btn-info{
    background-color: #bf2f58;
    border: 4px solid white;
    width: 200%;
}
.btn-info:hover{
    background-color: grey;
    border: 4px solid white;
}
.btn-success{
    background-color: #733292;
    border: 2px solid white;
    width: 70%;
}

.btn-success:hover{
    background-color: #bb67e4;
    border: 2px solid white;
}
           </style>
           
      </head>  
      <body>  
          <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
       <a class="navbar-brand" href="#" style="font-family:Courier; font-weight: 900; color: #d33451" >UNIPOLL</a>
    </div>

   
      
      <ul class="nav navbar-nav navbar-right">
          <li><a href="welcome.php">Home</a></li>
        <li class="active"><a href="createpoll.php">Create a Poll</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($sname); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="profile.php">Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

           <div class="container">  
              <br />  
             
              <div class="row">
  
</div>
              <h2 align="center">Create Your Poll</h2>  
              <div class="form-group">  
                   <form name="add_name" id="add_name">  
                        <div class="table-responsive">  
                             <table class="table boderless" id="dynamic_field">  
                                  <tr>  
                                        <td><input type="text" name="name[]" placeholder="Enter Question" class="form-control name_list" /></td>  
                                       <td><button background-color="#bf2f58" type="button" name="add" id="add" class="btn btn-success" >Add Options</button></td>     
                                 </tr>  
                               </table>  
                                 
                          </div> 
                                          

<div class="container">  
              <br />  
            
              <div class="row">
  
</div>
              </div>
                          <div><p align="left">Select Category</p></div>
  <div class="col-xs-3">
                          <select ng-model='discussionsSelect' class='form-control' id='category' name="category" >
                          <option value='subject'>Subject</option>
                          <option value='professor'>Professor</option>
                          <option value='sports'>Sports</option>
                          <option value='event'>Event</option>
                          <option value='other' selected>Others</option>
                         
                

              </select>
  </div>          
               </form>              
              <br>
             <div class="container">  
              <br />  
              <br />
              <div class="row">
  
</div>
              </div>
              <div class="container">  
              <br />
              <br />
              <div class="row">
  </div>
</div>
              
  	
          
              
              
              
           
            

<body>

 
            
              <div height="width: 80%">
              <input align="bottom" style="height:55px;width:200" type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
              </div>
                 

      </body>  
 </html>  
 
 
 
 
 <script>  
 $(document).ready(function(){  
      var i=1;  
      var selectedval;
      function getSelectedValue()
      {
        selectedval = document.getElementById("category").value;
        console.log(selectedval);
      }
      getSelectedValue();
      $("#category").on("change",getSelectedValue);
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter Option" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){ 
            var check = $('input[placeholder="Enter Question"]', '#add_name').val();  
 
            if(check === undefined || check.length == 0)    
            {
                  alert("Enter Option");
            } 
            else{
              $.ajax({  
                url:"savepolldb.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert("Enter Option");  
                     $('#add_name')[0].reset(); 
                     window.location.href = 'welcome.php'; 
                }  
              });
            } 
             
      });  
 });  
 </script>
 
