<?php include 'layouts/header.php' ?>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform validation and authentication logic
    // Check if the email and password are valid and match a user in the database
    // For simplicity, let's assume the user data is stored in a users table

    $dbConnection = mysqli_connect('localhost', 'root', '', 'to_do_task_management');

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Sanitize the user input to prevent SQL injection
    $email = mysqli_real_escape_string($dbConnection, $email);
    $password = mysqli_real_escape_string($dbConnection, $password);

    // Query the database for the user
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($dbConnection, $query);

    // Check if a user with the provided email exists
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create a session for the user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            // Redirect the user to the home page or any other desired page
            header("Location: home.php");
            exit();
        } else {
            // Invalid password
            $error = "Invalid email or password.";
        }
    } else {
        // User with the provided email does not exist
        $error = "Invalid email or password.";
    }

    // Close the database connection
    mysqli_close($dbConnection);
}
?>


    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" style="margin-top:10%">
        
        <h1 class="text-center">Login</h1>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required  autocomplete="new-password">
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </div>
    </form>
</body>
</html>


<?php include 'layouts/footer.php' ?>