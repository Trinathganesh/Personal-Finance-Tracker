<?php

session_start();

include("config/db.php");


if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];



$sql = "SELECT * FROM transactions
        WHERE user_id='$user_id'
        ORDER BY d_o_t DESC";


$result = mysqli_query($conn,$sql);


?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Transactions</title>


<link rel="stylesheet" href="css/view_transaction.css">


</head>


<body>


<div class="container">



<h1>
My Transactions
</h1>




<table>


<tr>

<th>Date</th>

<th>Category</th>

<th>Type</th>

<th>Amount</th>
<th>Action</th>
</tr>



<?php


if(mysqli_num_rows($result)>0)
{


while($row=mysqli_fetch_assoc($result))
{


?>


<tr>


<td>
<?php echo $row['d_o_t']; ?>
</td>


<td>
<?php echo $row['category']; ?>
</td>


<td class="<?php echo strtolower($row['type']); ?>">
<?php echo $row['type']; ?>
</td>


<td>
₹ <?php echo $row['amount']; ?>
</td>
<td>

<a href="edit_transaction.php?id=<?php echo $row['trans_id']; ?>">
    Edit
</a>

|


<a href="delete_transaction.php?id=<?php echo $row['trans_id']; ?>"
onclick="return confirm('Are you sure you want to delete?');">
Delete
</a>



</td>


</tr>


<?php

}

}

else

{

?>


<tr>

<td colspan="4">
No Transactions Available
</td>

</tr>


<?php

}


?>


</table>




<a href="dashboard.php">
← Back to Dashboard
</a>



</div>



</body>

</html>