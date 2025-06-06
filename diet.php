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
    <title>Diet Page</title>
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
        
        .diet-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .diet-details h2 {
            margin-top: 0;
        }
        
        .diet-details p {
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
        <div class="diet-details">
            <?php
            $x=$_SESSION["user"][1];
            if (isset($_POST["submit"])) {
           $log_date = $_POST["log_date"];
           $meal_type = $_POST["meal_type"];
           $food_item = $_POST["food_item"];
           $calories_consumed = $_POST["calories_consumed"];
           $protein = $_POST["protein"];
           $carbs = $_POST["carbs"];
           $fats = $_POST["fats"];
           
           require_once "database.php";
           $sql = "SELECT * FROM diet WHERE id = '$x'";
           $result = mysqli_query($conn, $sql);
           $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
           $sql = "INSERT INTO diet (id, log_date, meal_type, food_item, calories_consumed, protein, carbs, fats) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
           $stmt = mysqli_stmt_init($conn);
           $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
           if ($prepareStmt) {
               mysqli_stmt_bind_param($stmt,"ssssssss",$x,$log_date, $meal_type, $food_item, $calories_consumed, $protein, $carbs, $fats);
               mysqli_stmt_execute($stmt);
               echo "<div class='alert alert-success'>You have successfully entered.</div>";
           }else{
               die("Something went wrong");
           }
            }
        ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Enter Diet Details</h2>
                <input type="text" name="log_date" placeholder="Log Date" required>
                <input type="text" name="meal_type" placeholder="Meal Type" required>
                <input type="text" name="food_item" placeholder="Food Item" required>
                <input type="text" name="calories_consumed" placeholder="Calories Consumed" required>
                <input type="text" name="protein" placeholder="Protein" required>
                <input type="text" name="carbs" placeholder="Carbs" required>
                <input type="text" name="fats" placeholder="Fats" required>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
    <?php

    $sql = "SELECT log_date, meal_type, food_item, calories_consumed, protein, carbs, fats FROM diet where id='$x'";
    $conn = new mysqli("localhost", "root", "", "login");
    $ans = $conn->query($sql);
    
    // Check if any rows were returned
    if ($ans->num_rows > 0) {
        // Output data of each row
        while($row = $ans->fetch_assoc()) {
            echo "Log Date: " . $row["log_date"]. "<br>";
            echo "Meal Type: " . $row["meal_type"]. "<br>";
            echo "Food Item: " . $row["food_item"]. "<br>";
            echo "Calories Consumed: " . $row["calories_consumed"]. "<br>";
            echo "Protein: " . $row["protein"]. "<br>";
            echo "Carbs: " . $row["carbs"]. "<br>";
            echo "Fats: " . $row["fats"]. "<br>";
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