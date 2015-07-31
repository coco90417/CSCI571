<?php
    session_start();
    if(session_destroy()) // Destroying All Sessions
    {
        header("Location: index.php"); // Redirecting To Home Page
    }
    // Close database connection
    if (isset($connection)) {
        mysql_close($connection);
    }
    ?>
