<?php
session_start();
mb_internal_encoding('UTF-8');
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] === true) 
{
	header('Location: files.php');
	exit;
}
if ($_POST)
{
	if ($_POST['user'] == 'user' && $_POST['pass'] == 'qwerty')
	{
		$_SESSION['isLogged'] = true;
		header('Location: index.php');
		exit;
	}
	else
	{
		echo 'Грешни потребителско име и/или парола!';
	}
}
$pageTitle = 'Login';
include 'includes/header.php';
?>

<div id="site" class="container_12">
    <header>
        <h2>
            <a id="top"><?= $heading;?></a>
        </h2>
    </header>
    
    <nav class="grid_3">
        <ul>
            <?php include 'includes/nav.php'; ?>
        </ul>
    </nav>
    
    <section class="grid_9">
        <header>
            Вход
        </header>


	<form method="POST" action="">
		<table>
			<tr>
				<td>Потребителско име</td>
				<td><input type="text" required autofocus autocomplete="on" name="user" /></td>
			</tr>
			<tr>
				<td>Парола</td>
				<td><input type="password" required name="pass" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Влез" /></td>
			</tr>
		</table>
	</form>
	</section>
	</div>
<?php
include 'includes/footer.php';
?>