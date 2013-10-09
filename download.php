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
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    header('Location: files.php');
    exit;
}
else
{
    die('File does not exist!');
}
?>