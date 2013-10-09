<?php
session_start();
mb_internal_encoding('UTF-8');
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) 
{
	header('Location: index.php');
	exit;
}
$pageTitle = 'Files';
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
            Списък с качените файлове
        </header>

	<table class="form">
		<tr>
			<th>Last Changed</th>
			<th>Name</th>
			<th>Size</th>
			<th>View</th>
			<th>Download</th>
			<th>Rename</th>
			<th>Delete</th>
		</tr>
		<?php
		if (!($dir = realpath('uploads')))
		{
			die('Cannot find file repo!');
		}
		$files = scandir($dir);
		foreach ($files as $value)
		{
			if ($value == '.' || $value == '..')
			{
				continue;
			}
			$time = @filemtime($value);
			if ($time === false)
			{
				//var_dump($time);
				$lastChanged = '<unknown>';
			}
			else
			{
				$lastChanged = date('d.m.Y', $time);
			}
			echo '<tr><td>' . $lastChanged . '</td><td><a href="download.php?fileName=' . $value . '">' . $value . '</a></td><td>';
			if(is_file($value))
			{
				echo filesize($value);
			}
			echo '</td><td>';

			echo '<a href="view.php?fileName=' . $value . '"><img width="22px" src="img/myview_.png" /></a>';
			
			echo '</td>
				  <td><a href="download.php?fileName=' . $value . '"><img height="22px" src="img/mydownload_.png" /></a></td>
				  <td><a href="rename.php?fileName=' . $value . '"><img height="22px" src="img/myrename_.png" /></a></td>
				  <td><a href="delete.php?fileName=' . $value . '"><img height="22px" src="img/mydelete_.png" /></a></td></tr>';
		}
		?>
	</table>
		</section>
	</div>
<?php
include 'includes/footer.php';
?>