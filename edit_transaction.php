<?php
session_start();
include("config/db.php");


if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}


$user_id=$_SESSION['user_id'];


if(isset($_GET['id']))
{
    $id=$_GET['id'];

    $query=mysqli_query($conn,
    "SELECT * FROM transactions 
    WHERE trans_id='$id' 
    AND user_id='$user_id'");


    $data=mysqli_fetch_assoc($query);
}



if(isset($_POST['update']))
{

    $amount=$_POST['amount'];
    $type=$_POST['type'];
    $category=$_POST['category'];
    $date=$_POST['date'];


    $update=mysqli_query($conn,

    "UPDATE transactions SET

    amount='$amount',
    type='$type',
    category='$category',
    d_o_t='$date'

    WHERE trans_id='$id'
    AND user_id='$user_id'
    ");


    if($update)
    {
        header("Location:view_transaction.php");
        exit();
    }

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Edit Transaction</title>

<link rel="stylesheet" href="css/edit_transaction.css">

</head>


<body>


<div class="edit-box">

<h2>Edit Transaction</h2>


<form method="POST">


<label>Amount</label>

<input type="number" 
name="amount"
value="<?php echo $data['amount']; ?>"
required>


<label>Type</label>

<select name="type">

<option>
<?php echo $data['type']; ?>
</option>

<option>Income</option>

<option>Expense</option>

</select>



<label>Category</label>

<input type="text"
name="category"
value="<?php echo $data['category']; ?>">



<label>Date</label>

<input type="date"
name="date"
value="<?php echo $data['d_o_t']; ?>">



<button type="submit" name="update">
Update Transaction
</button>


</form>


</div>


</body>

</html>