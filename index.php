<?php
// index.php (your main entry point)

// Include any necessary PHP files, libraries, or configurations

// Start a PHP session if needed
session_start();

?>

<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', 'en_US'); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <title>To-Do Task Management</title>
        <link href="/assets/css/tailwind.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <a href="/home.php" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400   dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
        </div>
        <?php else : ?>
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                <a href="/login.php" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400      dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                <a href="register.php" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400    dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            </div>
        <?php endif; ?>

            <div class="container mt-5 d-block">
                <h1 class="text-center">To-Do Task Management</h1>
                <hr>
                <div class="text-center pb-5">
                    <a href="#" class="btn btn-primary">Create Task</a>
                    <a href="#" class="btn btn-secondary">View Tasks</a>
                    <a href="#" class="btn btn-info">Update Task</a>
                    <a href="#" class="btn btn-danger">Delete Task</a>
                </div>

                <footer class="text-center mt-5 pt-5">
                    <p>Developed by Jayhan Bairulla</p>
                </footer>
            </div>
            <br>
            
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        </div>
    </body>
</html>
