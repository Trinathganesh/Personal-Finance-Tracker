<?php
session_start();
include("config/db.php");

if(isset($_SESSION['user_id']))
{
    header("Location: dashboard.php");
    exit();
}

$error="";

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $sql="SELECT * FROM users WHERE email='$email' AND password='$password'";

    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $row=mysqli_fetch_assoc($result);

        $_SESSION['user_id']=$row['user_id'];
        $_SESSION['name']=$row['name'];

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $error="Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Finance Tracker - Login</title>

<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/login.css">
</head>

<body>

<div class="auth-container">

<div class="left-panel">

<div class="left-content">

<h1>💰 Finance Tracker</h1>

<p>

Track your income, manage expenses, plan budgets and achieve your financial goals with a clean and secure finance management system.

</p>

</div>

</div>

<div class="right-panel">

<div class="form-box">

<h2>Welcome Back 👋</h2>

<p class="subtitle">

Login to continue

</p>

<?php
if($error!="")
{
echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
placeholder="Enter Email"
required>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

</div>

<button
class="btn"
type="submit"
name="login">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

</form>

<div class="form-footer">

Don't have an account?

<a href="register.php">

Register

</a>

</div>

</div>

</div>

</div>

</body>

</html>