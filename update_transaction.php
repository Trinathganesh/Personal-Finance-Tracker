<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update']))
{
    $id = $_POST['trans_id'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $date = $_POST['d_o_t'];

    $query = "UPDATE transactions 
              SET amount='$amount',
                  type='$type',
                  category='$category',
                  d_o_t='$date'
              WHERE trans_id='$id'
              AND user_id='$user_id'";

    $result = mysqli_query($conn,$query);
    if($result)
{
    echo "
    <script>
        alert('Transaction Updated Successfully');
        window.location.href='view_transactions.php';
    </script>
    ";
    exit();
}
    else
    {
        echo "
        <script>
        alert('Update Failed');
        window.location='view_transactions.php';
        </script>
        ";
    }
}
?>