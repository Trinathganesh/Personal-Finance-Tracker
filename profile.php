<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,
"SELECT * FROM users WHERE user_id='$user_id'");

$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>

<div class="profile-container">

    <div class="profile-image">
        👤
    </div>

    <h2>My Profile</h2>

    <div class="profile-details">

        <label>Name</label>
        <p><?php echo $user['name']; ?></p>


        <label>Email</label>
        <p><?php echo $user['email']; ?></p>


        <label>Account Created</label>
        <p><?php echo $user['created_date']; ?></p>

    </div>


    <a href="dashboard.php" class="profile-btn">
        Back to Dashboard
    </a>

</div>

</body>
</html>