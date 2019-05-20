<?php
  require_once 'config.php';
  $pid = $_GET['qid'];

   $query = " SELECT topic FROM polls WHERE id=$pid ";
    $qresult = mysqli_query($link, $query);
    $qrow = mysqli_fetch_array($qresult);

    $sql = "Select username from users where id='$pid';";
                            
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
        $sname= $row['username'];
    }
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title> votes </title>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery-1.12.4.min.js">\x3C/script>')</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" />   
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
  <style type="text/css">
        body{ font: 14px sans-serif; color: white; ;text-align: left; margin-left: 10%;
    margin-right: 10%;
    margin-top: 5%;
    background: url(../img/bg-pattern.png),linear-gradient(to left,#7b4397,#dc2430); }
    </style>
    <style type="text/css">
        body{ 
    input[type="radio"] {
  margin: 0 10px 0 10px;
}
}
.btn-info{
    background-color: #bf2f58;
    border: 4px solid white;
    width: 200%;
}
.btn-info:hover{
    background-color: grey;
    border: 4px solid white;
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
        <li><a href="createpoll.php">Create a Poll</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span></a>
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
  <br />
  <div class="container" style="width:1000px;">
   <h2 style="font-size: 50px" align="left"><?php echo $qrow['topic'] ?> </h2>
      
      <hr>
      <form method="post" id="like_form">
      <?php
      $sub_query = "
         SELECT name, votes FROM options WHERE poll_id=$pid 
         ORDER BY id ASC";
      $result = mysqli_query($link, $sub_query);
      $data = array();
      while($row = mysqli_fetch_array($result))
      {
       $data[] = array(
        'label'  => $row['name'],
        'value'  => $row['votes']
       );
      }
      


        function generateRadioButtons($name , $options) {
        $name = htmlentities($name);
        $html = '';
        foreach($options as $d){
          //$value = htmlentities($value);
          $html .= '<input type="radio"';
          $html .= ' name="'.$name.'" value="'.$d['value'].'" id="'.$d['label'].'" />'.'  '.'<label  style="font-size: 19px;">'.$d['label'].'</label><br />'."\n";
          
        };
        return $html;
        }

        echo generateRadioButtons("opt",$data);
        $data = json_encode($data);
        
      ?>
<div class="container">  
              <br />  
            <br />
              <div class="row">
  
</div>
            
      <div class="form-group">
     <input align="left" style="height:40px;width:100px" type="submit" name="like" class="btn btn-info" value="Vote" />
    </div>
   </form>
      
     
   <canvas id="myChart" width="400" height="400"></canvas>
   <script type="text/javascript">

        var main = document.getElementById("myChart");
        var render = myChart.getContext("2d");
        main.width = 500;
        main.height = 500;
        main.style.left = "660px";
        main.style.top = "280px";
        main.style.position = "absolute";
    </script>
    
  
    
 </body>
</html>


 
<script>
$(document).ready(function(){

  var ctx = document.getElementById('myChart').getContext('2d');
  var quesID = <?php echo $pid?>;
  var jsArray = JSON.parse('<?php echo $data; ?>');
  var option = [];
  var nvote = [];
  for (var i in jsArray) {
   option.push(jsArray[i].label);
   nvote.push(jsArray[i].value);
  }

      var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'doughnut',
      // The data for our dataset
      data: {
          labels: option,
          datasets: [{
              label: "My First dataset",
              backgroundColor:  ['rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'],
              
              data: nvote,
          }]
      },

      // Configuration options go here
      options: {responsive: false,
  maintainAspectRatio: true,
  animation: false,
  legend: {
                display: true,
                position: 'right',
                onClick: null,
                labels: {
                  fontSize: 20,
                  fontColor: '#FFFFFF',
                }
            },
  }
  }); 

   $('#like_form').on('submit', function(event){
      event.preventDefault();
       $(this).find('input[type="submit"]').prop("disabled", true);
      var checked = $('input[name=opt]:checked', '#like_form').val();
      var optname = $('input[name=opt]:checked', '#like_form').attr('id');

      if(checked == undefined)
      {
       alert("Please Vote");
       return false;
      }
      else
      {
        
        $.post( "connectvote.php", { opt: checked+1 , name: optname , qid: quesID  })
          .done(function( data ) {
              jsArray = JSON.parse(data);
              option.length = 0;
              nvote.length = 0;
              for (var i in jsArray) {
               option.push(jsArray[i].label);
               nvote.push(jsArray[i].value);
              }
              chart.update();
          });   
      }
   }); //onsubmit

   var getData = function(){
    $.post( "connectvote.php", { opt: 0 , name: " ",  qid: quesID })
          .done(function( data ) {
            //alert(data);
              jsArray = JSON.parse(data);
              option.length = 0;
              nvote.length = 0;
              for (var i in jsArray) {
               option.push(jsArray[i].label);
               nvote.push(jsArray[i].value);
              }
              chart.update();
          });
   } //getdata
   

   setInterval(function() {getData()},100);
}); //ready
 
</script>
