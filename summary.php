<?php

session_start();

include("config/db.php");


if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


// Income

$sql = "SELECT IFNULL(SUM(amount),0) AS total 
        FROM transactions
        WHERE user_id='$user_id'
        AND type='Income'";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

$income = $row['total'];




// Expense

$sql = "SELECT IFNULL(SUM(amount),0) AS total 
        FROM transactions
        WHERE user_id='$user_id'
        AND type='Expense'";


$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

$expense = $row['total'];



// Category wise expense

$categoryData = [];

$sql = "SELECT category,SUM(amount) AS total
        FROM transactions
        WHERE user_id='$user_id'
        AND type='Expense'
        GROUP BY category";


$result = mysqli_query($conn,$sql);


while($row=mysqli_fetch_assoc($result))
{

    $categoryData[]=$row;

}


?>


<!DOCTYPE html>

<html>

<head>

<title>Summary</title>


<link rel="stylesheet" href="css/summary.css">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>


<body>



<div class="container">


<h1>
Financial Summary
</h1>



<div class="chart-box">


<h2>
Income vs Expense
</h2>


<canvas id="moneyChart"></canvas>


</div>





<div class="chart-box">


<h2>
Expense By Category
</h2>


<canvas id="categoryChart"></canvas>


</div>




<a href="dashboard.php">
← Back to Dashboard
</a>



</div>






<script>


const moneyChart = document.getElementById('moneyChart');


new Chart(moneyChart, {


type:'doughnut',


data:{


labels:['Income','Expense'],


datasets:[{

data:[
<?php echo $income; ?>,
<?php echo $expense; ?>
]

}]


}



});






const categoryChart = document.getElementById('categoryChart');


new Chart(categoryChart,{


type:'bar',


data:{


labels:[

<?php

foreach($categoryData as $data)
{

echo "'".$data['category']."',";

}

?>

],



datasets:[{

label:'Expense Amount',


data:[


<?php

foreach($categoryData as $data)
{

echo $data['total'].",";

}

?>


]


}]


}



});



</script>



</body>

</html>