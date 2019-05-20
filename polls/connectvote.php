<?php

// $connect = mysqli_connect("localhost", "root", "", "unipoll");

require_once 'config.php';

//  session_start();
//echo $_POST["name"];
//echo $_POST["opt"];
if(isset($_POST["opt"]) && !empty($_POST["opt"]))
{
	//echo $_POST["name"];
	//echo $_POST["opt"];
 $query = "
  UPDATE options SET votes= votes + 1 WHERE name='".$_POST["name"]."'
 ";
 mysqli_query($link, $query);
  $sub_query = "
         SELECT name, votes FROM options WHERE poll_id=".$_POST["qid"]." 
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
 $data = json_encode($data, JSON_NUMERIC_CHECK);
 echo $data;
}else
{
		//echo "failed to connect";
  
    $sub_query = "
         SELECT name, votes FROM options WHERE poll_id=".$_POST["qid"]." 
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
     $data = json_encode($data, JSON_NUMERIC_CHECK);
     echo $data;
}
?>