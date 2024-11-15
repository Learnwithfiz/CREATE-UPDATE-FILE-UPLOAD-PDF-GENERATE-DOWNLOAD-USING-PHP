<?php
// echo "<pre>";
// print_r($_POST);
include 'db.php';
if(isset($_POST['dltMulBtn']))
{
    $multi_id = $_POST['multi_id'];
    $id = implode(",",$multi_id);
    
    $del = "DELETE FROM user_info WHERE id in ($id)";
    $s = mysqli_query($con,$del);
    if($s)
    {
        header("location:index.php");
    }
}

?>