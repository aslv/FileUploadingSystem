<?php
session_start();
mb_internal_encoding('UTF-8');
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) 
{
	header('Location: index.php');
	exit;
}
$pageTitle = 'Upload';
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
            Качи файл
        </header>


	<?php
	function loadNeededExtensions() // returns whether we could use finfo objects and functions
	{
		if (!extension_loaded('fileinfo')) // if 'fileinfo' isn't loaded, we try to load it; else we have no problem
		{
			if (function_exists('dl')) // if we can use dl() we load dynamically the extension; else we can do nothing
			{
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
    			{
        			return @dl('php_fileinfo.dll');
    			}
    			else
    			{
        			return @dl('fileinfo.so');
    			}
			}
			else
			{
				return false;
			}
		}
		return true;
	}
	function getMIME($file)
	{
		if (loadNeededExtensions()) // if we can conduct deeper MIME check
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			if ($file['type'] == finfo_file($finfo, $file['name']))
			{
				finfo_close($finfo);
				return $file['type'];
			}
			else // MIME type mismatch => something's wrong
			{
				finfo_close($finfo);
				return false;
			}
		}
		return $file['type'];
	}
	function isTypeAllowed($file, $index)
	{
		$notAllowedTypes = file('danger.txt', FILE_IGNORE_NEW_LINES);
		$tempName = $file['tmp_name'][$index];
		$MIME = getMIME($file);
		if ($MIME === false) // if we detect MIME cheats, deny upload
		{
			return false;
		}
		if (is_executable($file['tmp_name'][$index])) // if file is executable, it's potentionally harmful - upload denied
		{
			return false;
		}
		$result = true;
		foreach ($notAllowedTypes as $type) // if we don't permit this file extention, deny upload
		{
			if ($MIME == $type)
			{
				$result = false;
				break;
			}
		}
		if ($GLOBALS['highLevelOfSecurity']) // if high level of security is set (see constants.php)
		{
			$notAllowedTypes = file('highDanger.txt', FILE_IGNORE_NEW_LINES);
			foreach ($notAllowedTypes as $type)
			{
				if ($MIME == $type)
				{
					$result = false;
					break;
				}
			}
		}
		return $result;
	}
	if ($_POST)
	{
		if (count($_FILES))
		{
			if (empty($_FILES['upl_file']))
			{
				die('No file(s) to upload.');
			}
			for ($i = 0, $count = count($_FILES['upl_file']['name']); $i < $count; $i++)
			{ 
				if ($_FILES['upl_file']['error'][$i] > 0)
				{
					die('Some errors arised with file \'' . $_FILES['upl_file']['name'][$i] . '\'.<br>');
				}
				if ($_FILES['upl_file']['size'][$i] > disk_free_space(getcwd()))
				{
					die('The file \'' . $_FILES['upl_file']['name'][$i] . '\' you upload exceeds free space on server.<br>');
				}
				if (!isTypeAllowed($_FILES['upl_file'], $i))
				{
					die('The file \'' . $_FILES['upl_file']['name'][$i] . '\' you upload is potentionally harmful and could not be uploaded!<br>');
				}
				if ($_FILES['upl_file']['size'][$i] > return_bytes(ini_get('upload_max_filesize')))
				{
					die('The file \'' . $_FILES['upl_file']['name'][$i] . '\' you upload exceeds maximum upload size.<br>');
				}
				if (is_uploaded_file($_FILES['upl_file']['tmp_name'][$i]))
				{
					$newName = $uploads . $d . basename($_FILES['upl_file']['name'][$i]);
					if (file_exists($newName))
					{
						die('File with the same name as \'' . $_FILES['upl_file']['name'][$i] . '\' already exists!<br>');
					}
					else
					{
						if (!move_uploaded_file($_FILES['upl_file']['tmp_name'][$i], $newName))
						{	
							die('Something went wrong while processing the file \'' . $_FILES['upl_file']['name'][$i] . '\'!<br>');
						}
						else
						{
							echo 'File \'' . $_FILES['upl_file']['name'][$i] . '\' successfully submitted!<br>';
						}
					}
				}
				else
				{
					die('File \'' . $_FILES['upl_file']['name'][$i] . '\' uploading failed!<br>');
				}
			} // end for
		} // end count($_FILES)
	} // end $_POST
	?>
		<form method="POST" action="upload.php" enctype="multipart/form-data">
			<input type="file" required multiple name="upl_file[]" />
			<input type="hidden" name="foo" />
			<br>
			<input type="submit" value="Upload" />
		</form>
			</section>
	</div>
<?php
include 'includes/footer.php';
?>