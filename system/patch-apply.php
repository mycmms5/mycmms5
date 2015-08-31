<?php
/**
* @package DEBUG
*/
$base_version='config_settings.inc.php';
$patch='config_settings-REMACLE.patch';

$errors = xdiff_file_patch($base_version,$patch,'config_settings-NEW.inc.php');
if (is_string($errors)) {
   echo "Rejects:\n";
   echo $errors;
}
?>
