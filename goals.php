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
    <title>Goals Page</title>
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
        
        .goal-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .goal-details h2 {
            margin-top: 0;
        }
        
        .goal-details p {
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
        <div class="goal-details">

            <?php
            $x=$_SESSION["user"][1];
            if (isset($_POST["submit"])) {
           $goal_type = $_POST["goal_type"];
           $target_weight = $_POST["target_weight"];
           $start_date = $_POST["start_date"];
           $end_date = $_POST["end_date"];
           $archieved = $_POST["archieved"];
           
           require_once "database.php";
           $sql = "SELECT * FROM goals WHERE id = '$x'";
           $result = mysqli_query($conn, $sql);
           $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
           $sql = "INSERT INTO goals (id, goal_type, target_weight, start_date, end_date, archieved) VALUES (?, ?, ?, ?, ?, ?)";
           $stmt = mysqli_stmt_init($conn);
           $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
           if ($prepareStmt) {
               mysqli_stmt_bind_param($stmt,"ssssss",$x,$goal_type, $target_weight, $start_date, $end_date, $archieved);
               mysqli_stmt_execute($stmt);
               echo "<div class='alert alert-success'>You have successfully entered.</div>";
           }else{
               die("Something went wrong");
           }
            }
        
        ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Enter Goal Details</h2>
                <input type="text" name="goal_type" placeholder="Goal Type" required>
                <input type="text" name="target_weight" placeholder="Target Weight" required>
                <input type="text" name="start_date" placeholder="Start Date" required>
                <input type="text" name="end_date" placeholder="End Date" required>
                <input type="text" name="archieved" placeholder="Achieved" required>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
    <?php

    $sql = "SELECT goal_type, target_weight, start_date, end_date, archieved FROM goals where id='$x'";
    $conn = new mysqli("localhost", "root", "", "login");
    $ans = $conn->query($sql);
    
    // Check if any rows were returned
    if ($ans->num_rows > 0) {
        // Output data of each row
        while($row = $ans->fetch_assoc()) {
            echo "Goal Type: " . $row["goal_type"]. "<br>";
            echo "Target Weight: " . $row["target_weight"]. "<br>";
            echo "Start Date: " . $row["start_date"]. "<br>";
            echo "End Date: " . $row["end_date"]. "<br>";
            echo "Achieved: " . $row["archieved"]. "<br>";
            echo "<hr>"; 
        }
    } else {
        echo "No data found";
    }
    
    // Close connection
    $conn->close();
    ?>    
    
</body>
</html>