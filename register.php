<?php
include 'layouts/header.php';
// Database configuration
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbDatabase = 'to_do_task_management';
$dbUsername = 'root';
$dbPassword = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;charset=utf8mb4", $dbUsername, $dbPassword);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to handle user registration
function registerUser($name, $email, $password)
{
    global $pdo;

    try {
        // Check if the email already exists
        $existingEmailStatement = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $existingEmailStatement->bindParam(':email', $email);
        $existingEmailStatement->execute();

        $emailExists = $existingEmailStatement->fetchColumn();

        if ($emailExists) {
            echo "<script> alert('email already exists');</script>";
            return false;
        }

        // Prepare the SQL statement
        $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind the parameters
        $statement->bindParam(':name', $name);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $hashedPassword);

        // Execute the statement
        $statement->execute();

        // Registration successful
        return true;
    } catch (PDOException $e) {
        // Registration failed
        die("Registration failed: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the registration function
    $registrationStatus = registerUser($name, $email, $password);

    if ($registrationStatus) {
        echo "<script>alert('registration sucess');</script>";
        header("Location: index.php");
        exit();
    } else {
        echo "Registration failed!";
    }
}
?>

<form method="POST" action="register.php" class="registrationForm">
    <div class="row mb-3">
        <h1 class="text-center">REGISTER</h1>
    </div>
    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="name" required autocomplete="name">
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
        </div>
    </div>

    <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
        </div>
    </div>

    <div class="row mb-3">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </div>
</form>
<?php 
include 'layouts/header.php';
?>
