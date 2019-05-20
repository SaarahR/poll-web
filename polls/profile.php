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

$pquery = "Select count(topic) as cnt from polls where uid='$ID';";
$result = $link->query($pquery);
$prow = $result->fetch_assoc();

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
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
        <li><a href="createpoll.php">Create a Poll</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($sname); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li ><a href="profile.php">Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    <div class="page-header">
        <h1>Polls you Created</h1>
    </div>
    
    <p>No of Polls: <?php echo $prow['cnt']?> </p>


<form method="post" id="question_form">
      <?php
      require_once 'config.php';
      $sub_query = "SELECT topic, id from polls where uid = $ID;";
      $result = mysqli_query($link, $sub_query);
      $data = array();
      while($row = mysqli_fetch_array($result))
      {
       $data[] = array(
        'question'  => $row['topic'],
        'qid' => $row['id']
       );
      }
     
       function generateListView($options) {
        $html = '';
        foreach($options as $d){
          $html .= '<div class="list-group">';
          $html .= '<a href="vote.php?qid='.$d['qid'].'" class="list-group-item">';
          $html .= '<h4>'.$d['question'].'</h4></a>';
        };
        return $html;
        }
       echo generateListView($data);
      ?>
</form>
</body>
</html>