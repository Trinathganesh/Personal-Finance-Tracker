<?php

session_start();

include("config/db.php");


if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];


// Total Income

$sql = "SELECT IFNULL(SUM(amount),0) AS total 
        FROM transactions 
        WHERE user_id='$user_id' 
        AND type='Income'";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

$totalIncome = $row['total'];



// Total Expense

$sql = "SELECT IFNULL(SUM(amount),0) AS total 
        FROM transactions 
        WHERE user_id='$user_id' 
        AND type='Expense'";


$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

$totalExpense = $row['total'];



// Total Budget

$sql = "SELECT IFNULL(SUM(amount),0) AS total 
        FROM budget 
        WHERE user_id='$user_id'";


$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

$totalBudget = $row['total'];



$balance = $totalIncome - $totalExpense;


?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Finance Tracker Dashboard</title>


<link rel="stylesheet" href="css/dashboard.css">


<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>


<body>


<div class="container">



<!-- Sidebar -->

<div class="sidebar">


<h2>
💰 Finance Tracker
</h2>



<ul>


<li>
<a class="active" href="dashboard.php">
<i class="fa-solid fa-house"></i>
Dashboard
</a>
</li>



<li>
<a href="add_transaction.php">
<i class="fa-solid fa-plus"></i>
Add Transaction
</a>
</li>



<li>
<a href="view_transaction.php">
<i class="fa-solid fa-list"></i>
View Transactions
</a>
</li>



<li>
<a href="budget.php">
<i class="fa-solid fa-wallet"></i>
Budget
</a>
</li>


<li> 
<a href="reports.php"> 
<i class="fa-solid fa-chart-line"></i> 
Reports 
</a> 
</li>
<li>
<a href="profile.php">
<i class="fa-solid fa-user"></i>
Profile
</a>
</li>



<li>
<a href="logout.php">
<i class="fa-solid fa-right-from-bracket"></i>
Logout
</a>
</li>


</ul>


</div>





<!-- Main Content -->


<div class="main">



<div class="topbar">


<h1>
Dashboard
</h1>


<h3>
Welcome, 
<span>
<?php echo $name; ?>
</span>
</h3>


</div>





<!-- Cards -->


<div class="cards">


<div class="card income">

<h4>
Total Income
</h4>

<h2>
₹ <?php echo number_format($totalIncome,2); ?>
</h2>

</div>
<div class="card expense">
<h4>
Total Expense
</h4>
<h2>
₹ <?php echo number_format($totalExpense,2); ?>
</h2>
</div>
<div class="card balance">
<h4>
Current Balance
</h4>
<h2>
₹ <?php echo number_format($balance,2); ?>
</h2>
</div>
<div class="card budget">
<h4>
Total Budget
</h4>
<h2>
₹ <?php echo number_format($totalBudget,2); ?>
</h2>
</div>
</div>
<!-- Recent Transactions -->
<div class="table-box">
<h2>
Recent Transactions
</h2>
<table>
<tr>
<th>Date</th>
<th>Category</th>
<th>Type</th>
<th>Amount</th>
</tr>
<?php
$sql = "SELECT * FROM transactions
        WHERE user_id='$user_id'
        ORDER BY d_o_t DESC
        LIMIT 5";
$result = mysqli_query($conn,$sql);
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
<td>
<?php echo $row['type']; ?>
</td>
<td>
₹ <?php echo $row['amount']; ?>
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
No Transactions Found
</td>
</tr>
<?php
}
?>
</table>
</div>
</div>
</div>
</body>
</html>
