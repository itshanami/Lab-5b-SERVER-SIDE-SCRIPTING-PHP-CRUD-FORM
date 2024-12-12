<?php
include 'database.php';
include 'user.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $userDetails = $user->getUser($matric);

    $db->close();

    if ($userDetails) {
        // Display the update form with fetched user data
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update User</title>
        </head>
        <body>
            <h1>Update User</h1>
            <form action="update.php" method="POST">
                <label for="matric">Matric:</label>
                <input type="text" id="matric" name="matric" value="<?php echo $userDetails['matric']; ?>" readonly>
                <br>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $userDetails['name']; ?>"><br>

                <label for="role">Access Level:</label>
                <select id="role" name="role">
                    <option value="student" <?php echo $userDetails['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
                    <option value="lecturer" <?php echo $userDetails['role'] == 'lecturer' ? 'selected' : ''; ?>>Lecturer</option>
                </select><br>

                <input type="submit" value="Update">
                <a href="read.php">Cancel</a>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}
?>
