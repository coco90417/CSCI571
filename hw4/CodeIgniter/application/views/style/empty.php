<?php
    session_destroy();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ?>
