<?php
function check_id($id)
{
    if (file_exists("private/new_product") && file_exists("private/product")) 
    {
        $newproduct = file_get_contents("private/new_product");
		$product = file_get_contents("private/product");
		if ($newproduct != "")
        {
            $newproduct = unserialize($newproduct);
            foreach ($newproduct as $key => $value)
            {
				if ($value['id'] == $id)
					return false;
            }
        }
		if ($product != "")
        {
            $product = unserialize($product);
			print_r($product);
            foreach ($product as $key => $value)
            {
				if ($value['id'] == $id)
					return false;
            }
        }
    }
    return true;
}

function check_cat($cat)
{
	$newproduct = file_get_contents("private/new_product");
	$product = file_get_contents("private/product");
	if ($newproduct != "")
	{
		$newproduct = unserialize($newproduct);
		foreach ($newproduct as $key => $value)
		{
			if ($value['cat'] == $cat)
				return false;
		}
	}
	if ($product != "")
	{
		$product = unserialize($product);
		foreach ($product as $key => $value)
		{
			if ($value['cat'] == $cat)
				return false;
		}
	}
}
if ($_POST['submit'] == "Ajouter")
{
	if (!check_id($_POST['id']))
		echo"id deja pris\n";
	else if (!check_cat($_POST['categorie']))
		echo"Categorie introuvable\n";
	else if (!isnum($_POST['prix']))
		echo"Prix non valide\n";
	else
	{
		$dir = "../private/";
		$file = $dir."new_product";
		if (!file_exists($dir))
			mkdir($dir);
		if (!file_exists($file))
			file_put_contents($file, null);
		$account = unserialize(file_get_contents('../private/product'));
		$tmp['id'] = $_POST['id'];
		$tmp['prix'] = $_POST['prix'];
		$tmp['url'] = $_POST['url'];
		$tmp['categorie'] = $_POST['categorie'];
		$account[] = $tmp;
		file_put_contents('../private/new_product', serialize($account));
		echo"created\n";
	}
}
?>

<html>
<body>

    <form method="POST" action="">
	Id: <br/><input type="text" name="id" required><br/><br/>
	Prix: <br/><input type="text" name="prix" required><br/><br/>
	url:<br/><input type="text" name="url" required><br/><br/>
	categorie:<br/><input type="text" name="categorie" required><br/><br />
        <input class="submitbutton" type="submit" name="submit" value="Ajouter">
    </form>

</body>
</html>