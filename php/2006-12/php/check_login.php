<?php

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
  $logged_in = 0;
  die("Access denied");
}

else {

  $_SESSION['username'] = addslashes($_SESSION['username']);

  $query = "select uPassword from users where uEmail =  '".$_SESSION['username']."'";

  $result = $db_wrapper->do_login($query);

  if(!$result || mysql_num_rows($result) != 1) {
    $logged_in = 0;
    unset($_SESSION['username']);
    unset($_SESSION['password']);
  }

  $db_pass = mysql_fetch_row($result);

  $db_pass[0] = stripslashes($db_pass[0]);
  $_SESSION['password'] = stripslashes($_SESSION['password']);

  if($_SESSION['password'] == $db_pass[0]) {
    $logged_in = 1;
    //echo "Logged in as: " . $_SESSION['username'] . "<br \>";
  }
  else {
    $logged_in = 0;
    unset($_SESSION['username']);
    unset($_SESSION['password']);
  }
}

unset($db_pass[0]);

$_SESSION['username'] = stripslashes($_SESSION['username']);

?>