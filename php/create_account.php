<?php 
function check_login($login)
{
    if (!file_exists("private/accounts"))
        return true;
    $datas = file_get_contents("private/accounts");
    $datas = unserialize($datas);
    foreach ($datas as $key => $value)
    {
        foreach($value as $key2 => $value2)
        {
            if ($value2 == $login)
                return false;
        }
    }
    return true;
}
if (!$_POST['login'] || !$_POST['passwd'] || $_POST['submit'] != "Creer son compte" || !$_POST['lastname'] || !$_POST['firstname'] || !$_POST['mail'] || !check_login($_POST['login']))
{
	if (!check_login($_POST['login']))
		echo"Nom de compte deja pris\n";
	else
		echo"Un champ est manquant\n";
	exit;
}
else
{
	$salt = file_get_contents("private/salt");
	$data = array();
	$data['login'] = $_POST['login'];
	$data['passwd'] = hash("whirlpool", $salt.$_POST['passwd']);
	$data['mail'] = $_POST['mail'];
	$data['lastname'] = $_POST['lastname'];
	$data['firstname'] = $_POST['firstname'];
	if (!file_exists("private/accounts"))
	{
		$account = array($data);
		$ser = serialize($account);
		file_put_contents("private/accounts", $ser);
	}
	else
	{
		$accounts = unserialize($file);
		$i = 0;
		while ($accounts[$i])
			$i++;
		$accounts[$i] = $data;
		$ser = serialize($accounts);
		file_put_contents("private/accounts", $ser);
	}
	echo"compte creer avec succes\n";
}
?>
