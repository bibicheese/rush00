<?php
function auth($login, $passwd)
{
	$file = file_get_contents("private/accounts");
	$accounts = unserialize($file);
	$salt = file_get_contents("private/salt");
	$hashed = hash("whirlpool", "$salt.$passwd");
	foreach ($accounts as $key)
	{
		echo "$login  :  $key['login']\n\n";
		echo "--> $hashed\n--> $key['passwd']\n";
		if ($login == $key['login'] && $hashed == $key['passwd'])
			return true;
	}
	return false;
}

session_start();
if (auth($_POST['login'], $_POST['passwd']))
{
    $_SESSION['loggued_on_user'] = $_POST['login'];
    echo"OK\n";
}
else
{
    $_SESSION['loggued_on_user'] = "";
    echo"ERROR\n";
}
?>