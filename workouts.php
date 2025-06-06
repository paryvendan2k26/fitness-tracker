<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Workouts Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        .container {
            width: 100%;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
        }
        
        .workout-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .workout-details h2 {
            margin-top: 0;
        }
        
        .workout-details p {
            margin-bottom: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Fitness Tracker</a>
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
        <div class="workout-details">
            <!-- Your existing HTML code -->

            <!-- Add a form to accept user input -->
            <?php
            $x=$_SESSION["user"][1];
            if (isset($_POST["submit"])) {
           $workout_date = $_POST["workout_date"];
           $workout_type = $_POST["workout_type"];
           $duration = $_POST["duration"];
           $calories_burnt = $_POST["calories_burnt"];
           $distance = $_POST["distance"];
           
           require_once "database.php";
           $sql = "SELECT * FROM workouts WHERE id = '$x'";
           $result = mysqli_query($conn, $sql);
           $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
           $sql = "INSERT INTO workouts (id,workout_date, workout_type, duration, calories_burnt, distance) VALUES (?, ?, ?, ?, ?, ?)";
           $stmt = mysqli_stmt_init($conn);
           $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
           if ($prepareStmt) {
               mysqli_stmt_bind_param($stmt,"ssssss",$x,$workout_date, $workout_type, $duration, $calories_burnt, $distance);
               mysqli_stmt_execute($stmt);
               echo "<div class='alert alert-success'>You have successfully entered.</div>";
           }else{
               die("Something went wrong");
           }
            }
        
        ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Enter Workout Details</h2>
                <input type="text" name="workout_date" placeholder="Workout Date" required>
                <input type="text" name="workout_type" placeholder="Workout Type" required>
                <input type="text" name="duration" placeholder="Duration" required>
                <input type="text" name="calories_burnt" placeholder="Calories Burnt" required>
                <input type="text" name="distance" placeholder="Distance" required>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
    <?php

    $sql = "SELECT workout_date, workout_type, duration, calories_burnt, distance FROM workouts where id='$x'";
    $conn = new mysqli("localhost", "root", "", "login");
    $ans = $conn->query($sql);
    
    // Check if any rows were returned
    if ($ans->num_rows > 0) {
        // Output data of each row
        while($row = $ans->fetch_assoc()) {
            echo "Workout Date: " . $row["workout_date"]. "<br>";
            echo "Workout Type: " . $row["workout_type"]. "<br>";
            echo "Duration: " . $row["duration"]. "<br>";
            echo "Calories: " . $row["calories_burnt"]. "<br>";
            echo "Distance: " . $row["distance"]. "<br>";
            echo "<hr>"; // Add a horizontal line between each workout for better readability
        }
    } else {
        echo "No data found";
    }
    
    // Close connection
    $conn->close();
    ?>    
    
</body>
</html>