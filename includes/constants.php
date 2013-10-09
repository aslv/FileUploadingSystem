<?php
$d = DIRECTORY_SEPARATOR;
$uploads = 'uploads';
$heading = 'Система за качване на файлове';
$highLevelOfSecurity = false; // if you would like to raise the level of security, set this var to true
function return_bytes($val)
{
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}
?>