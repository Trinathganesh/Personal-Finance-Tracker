<?php
include("config/db.php");

$message = "";

if(isset($_POST['register']))
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    // Check Email
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0)
    {
        $message = "<div class='error'>Email already exists!</div>";
    }
    else
    {
        $sql = "INSERT INTO users(name,email,password,created_date)
                VALUES('$name','$email','$password',CURDATE())";

        if(mysqli_query($conn,$sql))
        {
            echo "<script>
                    alert('Registration Successful');
                    window.location='login.php';
                  </script>";
        }
        else
        {
            $message = "<div class='error'>Registration Failed!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create Account</title>

<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/register.css">

</head>

<body>

<div class="auth-container">

<div class="left-panel">

<div class="left-content">

<h1>💰 Finance Tracker</h1>

<p>

Create your account and start managing your income,
expenses and monthly budgets in one place.

</p>

</div>

</div>

<div class="right-panel">

<div class="form-box">

<h2>Create Account</h2>

<p class="subtitle">

Register to continue

</p>

<?php
echo $message;
?>

<form method="POST">

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="name"
placeholder="Enter Full Name"
required>

</div>

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
placeholder="Create Password"
required>

</div>

<button
class="btn"
type="submit"
name="register">

<i class="fa-solid fa-user-plus"></i>

Create Account

</button>

</form>

<div class="form-footer">

Already have an account?

<a href="login.php">

Login

</a>

</div>

</div>

</div>

</div>

</body>

</html>