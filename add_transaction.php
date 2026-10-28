<?php

session_start();

include("config/db.php");


if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];



if(isset($_POST['submit']))
{

    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $date = $_POST['date'];


$sql = "CALL insert_transaction(
            '$user_id',
            '$amount',
            '$type',
            '$category',
            '$date'
        )";

if(mysqli_query($conn, $sql))
{
    echo "<script>
    alert('Transaction Added Successfully');
    window.location='dashboard.php';
    </script>";
}
else
{
    echo "Error: " . mysqli_error($conn);
}
}
?>
<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Add Transaction</title>


<link rel="stylesheet" href="css/add_transaction.css">


</head>



<body>



<div class="form-container">


<h2>
Add Transaction
</h2>



<form method="POST">



<label>
Amount
</label>

<input type="number" 
name="amount"
placeholder="Enter amount"
required>




<label>
Transaction Type
</label>


<select name="type" required>


<option value="">
Select Type
</option>


<option value="Income">
Income
</option>


<option value="Expense">
Expense
</option>


</select>





<label>
Category
</label>


<select name="category" required>


<option value="">
Select Category
</option>


<option value="Food">
Food
</option>


<option value="Travel">
Travel
</option>


<option value="Shopping">
Shopping
</option>


<option value="Bills">
Bills
</option>


<option value="Education">
Education
</option>


<option value="Other">
Other
</option>


</select>





<label>
Date
</label>


<input type="date"
name="date"
required>




<button type="submit" name="submit">
Add Transaction
</button>



</form>



<a href="dashboard.php">
← Back to Dashboard
</a>


</div>



</body>

</html>