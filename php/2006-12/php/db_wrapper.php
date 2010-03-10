<?php

class db_wrapper {
  var $host;
  var $user;
  var $password;
  var $connection;
  var $log;
  var $database;

  function db_wrapper() {
    if ($_SERVER['SERVER_NAME'] == 'myserver') {
      $this->host = 'myhost';
      $this->user = 'myuser';
      $this->password = 'mypassword'; 
    }
    else {
      $this->host = "localhost";
      $this->user = "root";
      $this->password = "swr4628";
    }
    $this->connection = NULL;
    $this->log = "errorlog.txt";
    $this->database = "v3s3";
  }

  function set_log($log) {
    $this->log = $log;
  }

  function connect() {

    $this->connection = mysql_connect($this->host, $this->user, $this->password);

    if(!$this->connection) {
      $this->log_error();
    }
  }

  function select_db() {
    $db_selected = mysql_select_db($this->database, $this->connection);

    if(!$db_selected) {
      $this->log_error();
    }
  }

  function do_query($query) {
    $result = mysql_query($query, $this->connection);

    if(!$result) {
      $this->log_error();
    }
    else {
      return $result;
    }
  }

  function do_login($query) {
    $result = mysql_query($query, $this->connection);
    return $result;
  }

  function fetch_array($result) {
    return mysql_fetch_array($result);
  }

  function close() {
    mysql_close($this->connection);
  }

  function log_error() {
    $error = date('m-d-y H:i:s') . " " .  mysql_error() . "\r\n";

    if (is_writable($this->log)) {
      $handle = fopen($this->log, 'a');
	   fwrite($handle, $error);
      fclose($handle);
    }

    header("Location: ../html/index.php?p=error");
  }
}

?>
