<?php

session_start();

include("config/db.php");


// Check login
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// ==========================================
// MONTHLY SAVINGS FUNCTION
// ==========================================

// Use current month number
$current_month = date('n');

// Call monthly_savings(user_id, month)
$savings_query = mysqli_query(
    $conn,
    "SELECT monthly_savings('$user_id', '$current_month') AS savings"
);

$savings_row = mysqli_fetch_assoc($savings_query);

$monthly_savings = $savings_row['savings'];


// ==========================================
// MONTHLY SPENDING REPORT VIEW
// ==========================================

$monthly_report = mysqli_query(
    $conn,
    "SELECT * FROM monthly_spending_report
     WHERE user_id='$user_id'"
);


// ==========================================
// CATEGORY EXPENSE SUMMARY VIEW
// ==========================================

$category_report = mysqli_query(
    $conn,
    "SELECT * FROM category_expense_summary
     WHERE user_id='$user_id'"
);


// ==========================================
// BUDGET VS ACTUAL VIEW
// ==========================================

$budget_report = mysqli_query(
    $conn,
    "SELECT * FROM budget_vs_actual
     WHERE user_id='$user_id'"
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Financial Reports</title>

<link rel="stylesheet"
      href="css/reports.css">

</head>


<body>


<div class="container">


<h1>
Financial Reports
</h1>


<p class="subtitle">
Reports generated using MySQL Views and Functions
</p>


<!-- ========================================== -->
<!-- MONTHLY SAVINGS -->
<!-- ========================================== -->

<section class="report-card">

<h2>
Monthly Savings
</h2>

<p class="description">
Calculated using the MySQL monthly_savings() function.
</p>

<div class="savings-box">

<h3>
Current Month Savings
</h3>

<h1>
₹<?php echo number_format($monthly_savings, 2); ?>
</h1>

</div>

</section>


<!-- ========================================== -->
<!-- MONTHLY SPENDING REPORT -->
<!-- ========================================== -->

<section class="report-card">

<h2>
Monthly Spending Report
</h2>

<p class="description">
Shows total expenses for each category by month.
</p>


<table>

<tr>

<th>User ID</th>

<th>Category</th>

<th>Month</th>

<th>Total Spent</th>

</tr>


<?php

if(mysqli_num_rows($monthly_report) > 0)
{

while($row = mysqli_fetch_assoc($monthly_report))
{

?>

<tr>

<td>
<?php echo $row['user_id']; ?>
</td>

<td>
<?php echo $row['category']; ?>
</td>

<td>
<?php echo $row['txn_month']; ?>
</td>

<td>
₹<?php echo number_format($row['total_spent'], 2); ?>
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
No spending data available.
</td>

</tr>

<?php

}

?>

</table>

</section>


<!-- ========================================== -->
<!-- CATEGORY EXPENSE SUMMARY -->
<!-- ========================================== -->

<section class="report-card">

<h2>
Category Expense Summary
</h2>

<p class="description">
Shows total expenses grouped by category.
</p>


<table>

<tr>

<th>User ID</th>

<th>Category</th>

<th>Total Spent</th>

</tr>


<?php

if(mysqli_num_rows($category_report) > 0)
{

while($row = mysqli_fetch_assoc($category_report))
{

?>

<tr>

<td>
<?php echo $row['user_id']; ?>
</td>

<td>
<?php echo $row['category']; ?>
</td>

<td>
₹<?php echo number_format($row['total_spent'], 2); ?>
</td>

</tr>

<?php

}

}

else

{

?>

<tr>

<td colspan="3">
No expense data available.
</td>

</tr>

<?php

}

?>

</table>

</section>


<!-- ========================================== -->
<!-- BUDGET VS ACTUAL -->
<!-- ========================================== -->

<section class="report-card">

<h2>
Budget vs Actual
</h2>

<p class="description">
Compares the planned budget with actual spending.
</p>


<table>

<tr>

<th>User ID</th>

<th>Category</th>

<th>Month</th>

<th>Budget</th>

<th>Actual Spending</th>

<th>Remaining Budget</th>

</tr>


<?php

if(mysqli_num_rows($budget_report) > 0)
{

while($row = mysqli_fetch_assoc($budget_report))
{

?>

<tr>

<td>
<?php echo $row['user_id']; ?>
</td>

<td>
<?php echo $row['category']; ?>
</td>

<td>
<?php echo $row['month']; ?>
</td>

<td>
₹<?php echo number_format($row['budget_amount'], 2); ?>
</td>

<td>
₹<?php echo number_format($row['actual_spending'], 2); ?>
</td>

<td>
₹<?php echo number_format($row['remaining_budget'], 2); ?>
</td>

</tr>

<?php

}

}

else

{

?>

<tr>

<td colspan="6">
No budget data available.
</td>

</tr>

<?php

}

?>

</table>

</section>


<a href="dashboard.php">
← Back to Dashboard
</a>


</div>


</body>

</html>