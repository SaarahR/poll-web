    <?php  
  
 require_once 'config.php';
 
session_start();
 
 if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$question = mysqli_real_escape_string($link, $_REQUEST['name'][0]);

$sid=$_SESSION['userid'];
$category = mysqli_real_escape_string($link, $_REQUEST['category']);
 //echo "$category";
// attempt insert query execution
$sql = "INSERT INTO polls (topic, category, uid) VALUES ('$question', '$category','$sid')";
if(mysqli_query($link, $sql)){
    //echo "Records added successfully.";
    //echo "$id";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 

$sql = "Select id from polls where uid='$sid' and topic='$question';";
                            
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
        $pid= $row['id'];
    }
}

$number = count($_POST["name"])-1;  
 if($number > 0) {
     for ($i=1; $i<=$number; $i++)
     {
         $options = mysqli_real_escape_string($link, $_REQUEST['name'][$i]);
         
         
         
         $sql = "INSERT INTO options (name, poll_id) VALUES ('$options', '$pid')";
if(mysqli_query($link, $sql)){
    //echo "Records added successfully.";
    //echo "$id";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
     }
     echo "Records added successfully.";
 }
// close connection
mysqli_close($link);

 
 ?>