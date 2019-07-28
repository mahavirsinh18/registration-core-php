<?php

session_start();
include "connect.php";
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['password']);
session_destroy();

header("location:login.php");

?>