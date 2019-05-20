<?php
// Initialize the session
require_once 'config.php';
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
  header("location: login.php");
   
}
else {
    
   $ID = $_SESSION['userid']; 
    
    $sql = "Select username from users where id='$ID';";
                            
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
        $sname= $row['username'];
    }
}
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery-1.12.4.min.js">\x3C/script>')</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
   
    <style type="text/css">
        body{ font: 14px sans-serif; color: white; ;text-align: center; margin-left: 10%;
    margin-right: 10%;
    margin-top: 5%;
    background: url(../img/bg-pattern.png),linear-gradient(to left,#7b4397,#dc2430); }
    </style>
    
    
  <style type="text/css">  
  .custom-select {
  position: absolute;
  left:185px;
top:235px;
  font-family: Arial;
}
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}
/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}
/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
}
/*style items (options):*/
.select-items {
  position: absolute;
  background-color: red;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}
/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}
.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}

input[type=button], input[type=submit] {
    background-color: #ac3973;
    border: 4px solid white;
    position: absolute;
     top: 0px;
  left: 150px;
    border: none;
    color: white;
    padding: 6px 16px;
    text-decoration: none;
    margin: 4px 2px;
    cursor: pointer;
    
    
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
          <li class="active"><a href="#">Home</a></li>
        <li><a href="createpoll.php">Create a Poll</a></li>
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


    <div class="page-header">
        <h1>Published Votes</h1>
    </div>
    
    
 
<form method="post" id="question_form">
    
    <div><p align="left">Filter </p></div>
     <div class="custom-select">
                          <select  name="category" ng-model='discussionsSelect' class='form-control'>
                          <option value='subject'>Subject</option>
                          <option value='professor'>Professor</option>
                          <option value='sports'>Sports</option>
                          <option value='event'>Event</option>
                          <option value='other'>Others</option>
                          <option value='unselected' selected>Select Category</option>

                          <input type = "submit" />
              </select>

 </div>   

 
   
     <div class="container">  
              <br />  
            
              <div class="row">
  
</div>
    

      <?php
      require_once 'config.php';
      //$category = filter_input(INPUT_POST,"category");
if (!isset($_POST['category']))
      {
        $sub_query = "
         SELECT t1.username, t2.topic, t2.id FROM (select username , id from users) t1 join polls t2 on t1.id = t2.uid ";
      $result = mysqli_query($link, $sub_query);
      $data = array();
      while($row = mysqli_fetch_array($result))
      {
       $data[] = array(
        'user'  => $row['username'],
        'question'  => $row['topic'],
        'qid' => $row['id']
       );
      }
     
      function generateListView1($options) {
        $html = '';
        foreach($options as $d){
          $html .= '<div class="list-group">';
          $html .= '<a href="vote.php?qid='.$d['qid'].'" class="list-group-item">';
          $html .= '<h4>'.$d['question'].'</h4> 
                <p>Posted by '.$d['user'].'</p></a>';
        };
        return $html;
        }
       echo generateListView1($data);
     }

     else if (isset($_POST['category']))
      {
      $category = $_POST['category'];
      echo "<p style='color:white; font-size:230%'>".$category."</p>";
      
      $where = '';
    switch ($category) {
      case "subject":
        $where = "subject";
        break;
      case "2":
        $where = 'professor';
        break;
      case "3":
        $where = 'sports';
        break;
      case "4":
        $where = 'event';
        break;
      case "other":
        $where = 'other';
        break;
      }




       


      //echo $where;

      $sub_query = "
         SELECT t1.username, t2.topic, t2.id FROM (select username , id from users) t1 join polls t2 on t1.id = t2.uid AND t2.category = '$category'";
      $result = mysqli_query($link, $sub_query);
      $data = array();
      while($row = mysqli_fetch_array($result))
      {
       $data[] = array(
        'user'  => $row['username'],
        'question'  => $row['topic'],
        'qid' => $row['id']
       );
      }
     
      

      
       function generateListView($options) {
        $html = '';
        foreach($options as $d){
          $html .= '<div class="list-group">';
          $html .= '<a href="vote.php?qid='.$d['qid'].'" class="list-group-item">';
          $html .= '<h4>'.$d['question'].'</h4> 
                <p>Posted by '.$d['user'].'</p></a>';
        };
        return $html;
        }
       echo generateListView($data);

       
    }

       
      ?>

    
</form>   
</body>
</html>