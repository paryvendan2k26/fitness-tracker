<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <title>User Dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php ">Fitness Tracker</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="workouts.php">Workouts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="diet.php">Diet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="goals.php">Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user_details.php">User Details</a>
                        </li>
                        <li class="align-items-end">
                            <a href="logout.php" class="btn btn-warning">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <div class="container">
        <h1>Welcome <?php echo $_SESSION["user"][2]?></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Track Your Workouts</h5>
                        <p class="card-text">Stay motivated and keep track of your workouts with our easy-to-use fitness tracker.</p>
                        <a href="workouts.php" class="btn btn-light">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Manage Your Diet</h5>
                        <p class="card-text">Take control of your nutrition and manage your diet effectively with our diet tracking feature.</p>
                        <a href="diet.php" class="btn btn-light">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
       
    <?php
    // Generate a random quote
    $quotes = [
        "The only way to do great work is to love what you do. - Steve Jobs",
        "Success is not the key to happiness. Happiness is the key to success. - Albert Schweitzer",
        "Believe you can and you're halfway there. - Theodore Roosevelt",
        "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt",
        "The only limit to our realization of tomorrow will be our doubts of today. - Franklin D. Roosevelt"
    ];
    $randomQuote = $quotes[array_rand($quotes)];
    ?>
           
    <div class="container">
        <blockquote class="blockquote text-center">
            <p class="mb-0"><?php echo $randomQuote; ?></p>
        </blockquote>
    </div>

</body>
</html>