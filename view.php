<?php
session_start();
mb_internal_encoding('UTF-8');
require 'includes/constants.php';
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) 
{
	header('Location: index.php');
	exit;
}
?>
<?php
if (!isset($_GET['fileName']))
{
    exit;
}
$file = realpath($uploads . $d . $_GET['fileName']); // for validation
if (file_exists($file))
{
	show_source($file);
}
else
{
	die('File does not exist!');
}
?>
<br>
<input type="button" value="Back" onclick="history.back(-1)" />