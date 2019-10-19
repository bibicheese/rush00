<?php
function auth($login, $passwd)
{
	$file = file_get_contents("private/accounts");
	$accounts = unserialize($file);
	$salt = file_get_contents("private/salt");
	$hashed = hash("whirlpool", "$salt.$passwd");
	foreach ($accounts as $key => $value)
	{
		if ($login == $value["login"] && $hashed == $value["passwd"])
			return true;
	}
	return false;
}

session_start();
if (!$_POST['passwd'] || !$_POST['login'] || !$_POST['confirm'] || $_POST['submit'] != "se connecter")
	echo"champ manquant";
if ($_POST['passwd'] != $_POST['confirm'])
	echo"Pas le meme mot de passe";
if (auth($_POST['login'], $_POST['passwd']))
{
    $_SESSION['loggued_on_user'] = $_POST['login'];
    echo"Bienvenue ".$_POST['login']."\n";
}
else
{
    $_SESSION['loggued_on_user'] = "";
    echo"Erreur dans le nom de compte ou le mot de passe\n";
}
?>