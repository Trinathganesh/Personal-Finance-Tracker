<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    mysqli_query($conn,
    "DELETE FROM transactions 
     WHERE trans_id='$id' 
     AND user_id='$user_id'");

    echo "
    <script>
    alert('Transaction Deleted Successfully');
    window.location.href='view_transaction.php';
    </script>
    ";
}
?>