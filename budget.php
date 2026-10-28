<?php

session_start();

include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// ==========================================
// ADD BUDGET
// ==========================================

if(isset($_POST['submit']))
{
    $category = $_POST['category'];
    $amount = $_POST['amount'];

    // Convert YYYY-MM to month name
    $month_input = $_POST['month'];
    $month = date('F', strtotime($month_input . '-01'));

    $sql = "INSERT INTO budget
            (user_id, category, amount, month)
            VALUES
            ('$user_id','$category','$amount','$month')";

    if(mysqli_query($conn, $sql))
{
    echo "<script>
    alert('Budget Added Successfully');
    window.location.href = 'budget.php?refresh=" . time() . "';
    </script>";
    exit();
}
}


// ==========================================
// UPDATE BUDGET USING STORED PROCEDURE
// ==========================================

if(isset($_POST['update_budget']))
{
    $category = $_POST['update_category'];
    $month = $_POST['update_month'];
    $new_amount = $_POST['new_amount'];

    $sql = "CALL update_budget(
                '$user_id',
                '$category',
                '$month',
                '$new_amount'
            )";

    if(mysqli_query($conn, $sql))
    {
        header("Location: budget.php?updated=1");
        exit();
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}


// ==========================================
// GET ALL BUDGETS
// ==========================================

$sql = "SELECT *
        FROM budget
        WHERE user_id='$user_id'
        ORDER BY budget_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Budget</title>

<link rel="stylesheet" href="css/budget.css">

</head>

<body>


<?php

// ==========================================
// SUCCESS MESSAGE
// ==========================================

if(isset($_GET['added']))
{
    echo "<script>
    alert('Budget Added Successfully');
    </script>";
}

if(isset($_GET['updated']))
{
    echo "<script>
    alert('Budget Updated Successfully');
    </script>";
}

?>


<div class="container">


<h1>
Budget Planning
</h1>


<!-- ========================================== -->
<!-- ADD BUDGET -->
<!-- ========================================== -->

<div class="budget-form">

<form method="POST">

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
Amount
</label>

<input type="number"
name="amount"
placeholder="Enter budget amount"
step="0.01"
required>


<label>
Month
</label>

<input type="month"
name="month"
required>


<button type="submit" name="submit">
Add Budget
</button>

</form>

</div>


<!-- ========================================== -->
<!-- UPDATE BUDGET -->
<!-- ========================================== -->

<div class="budget-form">

<h2>
Update Budget
</h2>


<form method="POST">


<label>
Category
</label>

<select name="update_category" required>

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
Month
</label>

<select name="update_month" required>

<option value="">
Select Month
</option>

<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>
<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>

</select>


<label>
New Budget Amount
</label>

<input type="number"
name="new_amount"
placeholder="Enter new budget amount"
step="0.01"
required>


<button type="submit" name="update_budget">
Update Budget
</button>

</form>

</div>


<!-- ========================================== -->
<!-- BUDGET TABLE -->
<!-- ========================================== -->

<div class="table-box">


<h2>
Your Budgets
</h2>


<table>

<tr>

<th>Category</th>

<th>Amount</th>

<th>Month</th>

</tr>


<?php

if(mysqli_num_rows($result) > 0)
{

while($row = mysqli_fetch_assoc($result))
{

?>

<tr>

<td>
<?php echo $row['category']; ?>
</td>

<td>
₹ <?php echo number_format($row['amount'], 2); ?>
</td>

<td>
<?php echo $row['month']; ?>
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
No Budget Added
</td>

</tr>

<?php

}

?>

</table>


</div>


<a href="dashboard.php">
← Back to Dashboard
</a>


</div>


</body>

</html>

