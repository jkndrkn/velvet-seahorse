<?php

session_start();

unset($_SESSION['username']);
unset($_SESSION['password']);

$_SESSION = array();
session_destroy();
header('Location: index.php?p=main');

?>