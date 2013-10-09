<?php
session_start();
mb_internal_encoding('UTF-8');
require 'includes/constants.php';
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) 
{
	header('Location: index.php');
	exit;
}
if ($_POST)
{
	if (!isset($_POST['fileName']))
	{
	    exit;
	}
	$file = realpath($uploads . $d . $_POST['fileName']); // for validation
	if (file_exists($file))
	{
		$newName = htmlspecialchars($_POST['newName']);
		if(!rename($file, $newName))
		{
			header('Location: index.php');
			exit;
		}
		header('Location: files.php');
		exit;
	}
	else
	{
		die('File does not exist!');
	}
}
?>

<form action="rename.php" method="POST">
	Въведете новото име на файла:
	<input type="text" required name="newName" />
	<input type="hidden" name="fileName" value="<?= $_GET['fileName']; ?>" />
	<input type="submit" value="Готово" />
</form>