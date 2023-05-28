
<?php include 'layouts/header.php'?>
<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // If the user is logged in and the logout button is clicked, destroy the session
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}?>
<?php
$dbConnection = mysqli_connect('localhost', 'root', '', 'to_do_task_management');
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Retrieve the name from the database
    $query = "SELECT name FROM users WHERE id = $userId";
    $result = mysqli_query($dbConnection, $query);
    $name = '';
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];

    } else {
    }
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();

}?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Make sure the form is submitted
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['category_id'])) {
        // Get the form inputs
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $user_id = $_SESSION['user_id'];

        // Call the addTask function
        if (addTask($dbConnection, $title, $description, $category_id, $user_id)) {
            // Task added successfully
            $title = '';
            $description = '';
            $category_id = '';
            $user_id = '';

            // Redirect the user to a different page or the same page using GET method
            header('Location: home.php');
            exit();
        } else {
            // Failed to add task
            echo "Failed to add task.";
        }
    }
}
function addTask($dbConnection, $title, $description, $category_id, $user_id)
{
    // Escape special characters to prevent SQL injection
    $title = mysqli_real_escape_string($dbConnection, $title);
    $description = mysqli_real_escape_string($dbConnection, $description);

    // Insert the task into the database
    $query = "INSERT INTO tasks (category_id, title, description, user_id) VALUES ($category_id, '$title', '$description', $user_id)";
    $result = mysqli_query($dbConnection, $query);

    $title = '';
    $description = '';
    $category_id = '';
    $user_id = '';
    if ($result) {
        // Task added successfully
        return true;
    } else {
        // Failed to add task
        return false;
    }
}

// Function to update the task's completed status
function updateTaskCompleted($taskId, $completed)
{
    global $pdo;

    try {
        // Prepare the SQL statement
        $statement = $pdo->prepare("UPDATE tasks SET completed = :completed WHERE id = :id");

        // Bind the parameters
        $statement->bindParam(':completed', $completed);
        $statement->bindParam(':id', $taskId);

        // Execute the statement
        $statement->execute();

        // Update successful
        return true;
    } catch (PDOException $e) {
        // Update failed
        die("Update failed: " . $e->getMessage());
    }
}

// Usage example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['undo_task'])) {
        $taskId = $_POST['undo_task'];

        // Call the undoTask function
        $undoStatus = undoTask($taskId);

        if ($undoStatus) {
        } else {
            echo "Failed to undo task.";
        }
    } elseif (isset($_POST['complete_task'])) {
        $taskId = $_POST['complete_task'];

        // Call the completeTask function
        $completeStatus = completeTask($taskId);

        if ($completeStatus) {
            echo "<script>alert('Task completed successfully!');</script>";
            // Redirect the user to a different page or the same page using GET method
            header('Location: home.php');
            exit();
        } else {
            echo "Failed to complete task.";
        }
    }
}
function completeTask($taskId) {
    // Implement the logic to mark the task as completed in your database
    // You can use your database connection and perform the necessary update query here
    // Return true if the task is marked as completed successfully, or false otherwise
    
    // Example code (replace with your own implementation)
    $dbConnection = mysqli_connect("localhost", "root", "", "to_do_task_management");
    if (!$dbConnection) {
        // Handle the database connection error
        return false;
    }

    // Escape the task ID to prevent SQL injection
    $taskId = mysqli_real_escape_string($dbConnection, $taskId);

    // Update the task as completed in the database
    $query = "UPDATE tasks SET completed = 1 WHERE id = '$taskId'";
    $result = mysqli_query($dbConnection, $query);

    // Check if the update was successful
    if ($result) {
        // Task completed successfully
        return true;
    } else {
        // Failed to complete task
        return false;
    }
}

function undoTask($taskId) {
    // Implement the logic to undo the completion of the task in your database
    // You can use your database connection and perform the necessary update query here
    // Return true if the task completion is undone successfully, or false otherwise
    
    // Example code (replace with your own implementation)
    $dbConnection = mysqli_connect("localhost", "root", "", "to_do_task_management");
    if (!$dbConnection) {
        // Handle the database connection error
        return false;
    }

    // Escape the task ID to prevent SQL injection
    $taskId = mysqli_real_escape_string($dbConnection, $taskId);

    // Update the task as not completed in the database
    $query = "UPDATE tasks SET completed = 0 WHERE id = '$taskId'";
    $result = mysqli_query($dbConnection, $query);

    // Check if the update was successful
    if ($result) {
        // Task completion undone successfully
        return true;
    } else {
        // Failed to undo task completion
        return false;
    }
}
function deleteTask($taskId) {
    $dbConnection = mysqli_connect("localhost", "root", "", "to_do_task_management");
    if (!$dbConnection) {
        // Handle the database connection error
        return false;
    }

    // Escape the task ID to prevent SQL injection
    $taskId = mysqli_real_escape_string($dbConnection, $taskId);

    // Update the task as not completed in the database
    $query = "DELETE FROM tasks WHERE id = '$taskId'";
    $result = mysqli_query($dbConnection, $query);

    // Check if the update was successful
    if ($result) {
        // Task completion undone successfully
        return true;
    } else {
        // Failed to undo task completion
        return false;
    }
}
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_task'])) {
            $taskId = $_POST['delete_task'];

            // Call the deleteTask function
            $deleteStatus = deleteTask($taskId);

            if ($deleteStatus) {
                // Redirect the user to a different page or the same page using GET method
                header('Location: home.php');
                exit();
            } else {
                echo "Failed to delete task.";
            }
        }
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}



?>
<?php
// Check if the database connection is successful
if (!$dbConnection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<div class="row p-0 m-0">
    <div class="col-3" id="UserContainer">
        <div class="row user-container-row">
            <div class="col-12 user-details px-4 pb-3" >
                <form method="POST" action="" class="mt-3">
                    <img src="assets/img/Profile-Pic.jpg" class="profile-picture mb-3" alt="Profile Picture">
                    <h3 class="user-name mb-2">
                        <?php
                        echo "Welcome, " . $name; ?>
                    </h3>
                    <button type="submit" name="logout" class="logout">Logout</button>
                </form>
            </div>
            <div class="col-12 pt-3">
                <h2>ADD TASK</h2>
                <form class="add-task-container" method="POST" action="home.php">
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                    </div>
                    <div class="form-group mb-2">
                        <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <select class="form-control" id="category" name="category_id" required>
                            <option value="" selected disabled>Select Category</option>
                            <?php
                            $categoriesQuery = "SELECT * FROM categories";
                            $categoriesResult = mysqli_query($dbConnection, $categoriesQuery);
                            while ($category = mysqli_fetch_assoc($categoriesResult)) {
                                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>

    </div>
    <div class="col-12 col-md-9" id="taskContainer">
        <div class="row">
            <div class="col-12 pt-3 ps-4 Todo-Task-Header" style="
            background-image: url('assets/img/task-header-bg.png')">
                <button class="transparent-button mb-5 pb-4" type="button" id="toggleBtn">
                    <span class="fas fa-bars"></span>
                </button>
                <h2 class="tasks-header"> To Do Tasks</h2>
                <p><?php echo date('l j F'); ?></p>
            </div>
            <div class="col-12 todo-task-container">
                <?php
                $tasksQuery = "SELECT * FROM tasks";
                $tasksResult = mysqli_query($dbConnection, $tasksQuery);
                while ($task = mysqli_fetch_assoc($tasksResult)) {
                    if ($task['user_id'] == $_SESSION['user_id']) {
                        ?>
                    <div class="my-3" id="accordion">
                            <div class="accordion-item" style="border:1px solid black">
                                <div class="row accordion-header py-2" id="heading<?php echo $task['id']; ?>">
                                    <div class="col-4 ps-4">
                                        <?php echo $task['title']; ?>
                                    </div>
                                    <div class="col-4 text-center">
                                        <?php echo $task['completed'] ? 'Completed' : 'On Progress'; ?>
                                    </div>
                                    <div class="col-4 expand-accordion pe-4 d-flex justify-content-end">
                                        <button class="accordion-button d-flex justify-content-end" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse<?php echo $task['id']; ?>" aria-expanded="true"
                                            aria-controls="collapse<?php echo $task['id']; ?>" onclick="toggleAccordion(this)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapse<?php echo $task['id']; ?>" class="accordion-collapse collapse"
                                    aria-labelledby="heading<?php echo $task['id']; ?>" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th class="task-description-header">Description</th>
                                                        <th>Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $task['title']; ?></td>
                                                        <td class="task-description-content"><?php echo $task['description']; ?></td>
                                                        <td><?php echo $task['category_id']; ?></td>
                                                        <td class="action-task-container d-flex text-center">
                                                        <?php if ($task['completed']): ?>
                                                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                                <input type="hidden" name="undo_task" value="<?php echo $task['id']; ?>">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-undo"></i>
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                                <input type="hidden" name="complete_task" value="<?php echo $task['id']; ?>">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                            <?php if ($task['completed']): ?>
                                                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display: inline-block;">
                                                                    <input type="hidden" name="delete_task" value="<?php echo $task['id']; ?>">
                                                                    <button type="submit" class="btn btn-danger ms-1">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php
                    }
                }
                if (mysqli_num_rows($tasksResult) == 0) {
                    ?>
                    <div class="text-center no-task">
                        <i class="fas fa-check"></i> <br> No Task
                    </div>
                <?php
                }
                ?>

                <div class="task-overlay"></div>
            </div>
        </div>
    </div>
</div>
<?php include 'layouts/footer.php'?>
