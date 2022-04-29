<?php
session_start();
include "db.php";
include "../admin/includes/functions.php";
session_start(); // turn on sessions

// if login form submit button is clicked
if (isset($_POST['login'])) {

    login_user($_POST['username'], $_POST['password']);


} else {
    header("Location: ../index.php");
}
