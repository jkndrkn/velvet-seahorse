<?php

session_start();

if($login_ok == false) {
	header("Location:index.php?p=main");
}

if (isset($_POST['submit'])) {


	if(!$_POST['uname'] || !$_POST['passwd']) {
	    print_form('Invalid username or password.');
	    die();
	}

	if (!get_magic_quotes_gpc()) {
		$_POST['uname'] = addslashes($_POST['uname']);
	}

    $query = "select uEmail, uPassword from users where uEmail = '".$_POST['uname']."'";

    $result = $db_wrapper->do_login($query);

	if (!$result || mysql_num_rows($result) == 0) {
	    print_form('Invalid username or password.');
	    die();
	}

	$info = mysql_fetch_row($result);

	$_POST['passwd'] = stripslashes($_POST['passwd']);
	$_POST['passwd'] = mysql_real_escape_string($_POST['passwd']);
	$info[1] = stripslashes($info[1]);
	$_POST['passwd'] = md5($_POST['passwd']);

	//echo $_POST['passwd'] . " " . $info[1] . "\n";

	if ($_POST['passwd'] != $info[1]) {
	    print_form('Invalid username or password.');
	    die();
	}

	$_POST['uname'] = stripslashes($_POST['uname']);
	$_POST['uname'] = mysql_real_escape_string($_POST['uname']);
	$_SESSION['username'] = $_POST['uname'];
	$_SESSION['password'] = $_POST['passwd'];

	echo "Username: " . $_POST['uname'] . "<br \>";
    echo "Username: " . $_SESSION['username'];

	header("Location: admin.php");
?>

<?php

}
else {
  print_form();
}


function print_form($error_message = '') {

?>
<?php include '../html/head_spacer.html'; ?>

<p class="heading">LOGIN</p>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <form name="loginform" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?p=login"; ?>">
    <td>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" >
      <tr>
        <td width="78">Username:</td>
        <td width="294"><input name="uname" type="text" id="username"></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input name="passwd" type="password" id="password"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input class="button" type="submit" name="submit" value="Login"></td>
      </tr>
      <tr>
	    <td>&nbsp;</td>
	    <td><b><span class="error"><?php echo $error_message; ?></span></b></td>
	  </tr>
    </table>
    </td>
    </form>
  </tr>
</table>

<img src="../img/spacer.gif" height="250" width="1"><br />
<?php
}
?>
