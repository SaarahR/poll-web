<?php
require_once 'config.php';

if(isset($_POST['user_comm']) && isset($_POST['user_name']))
{
  $comment=$_POST['user_comm'];
  $name=$_POST['user_name'];
  $id=$_POST['user_id'];
//echo $comment;
  $query="insert into comments values('','$name','$comment',CURRENT_TIMESTAMP,'$id')";
  
  mysqli_query($link, $query);


$comm = "select name,comment,post_time from comments where name='$name' and comment='$comment' and qid='$id'";
    $results = mysqli_query($link, $comm);

  //$select=mysqli_query("select name,comment,post_time from comments where name='$name' and comment='$comment' and id='$id'");
  
  if($row=mysqli_fetch_array($results))
  {
	  $name=$row['name'];
	  $comment=$row['comment'];
      $time=$row['post_time'];
  ?>
      <div class="comment_div"> 
	    <p class="name">Posted By:<?php echo $name;?></p>
        <p class="comment"><?php echo $comment;?></p>	
	    <p class="time"><?php echo $time;?></p>
	  </div>
  <?php
  }
exit;
}
else{
  echo "error";
}

?>