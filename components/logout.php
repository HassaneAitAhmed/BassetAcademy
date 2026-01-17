<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout']) && $_POST['logout'] === 'true') {
        session_unset();
        session_destroy();
        exit();
    }
}
?>