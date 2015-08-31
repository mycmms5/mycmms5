<?php
$path = "../../../mycmms5/";

function readDirs($main){
  $dirHandle = opendir($main);
  while($file = readdir($dirHandle)) {
    if(is_dir($main.$file) && $file != '.' && $file != '..'){
        readDirs($main.$file."/");
    }
    else {
        $extension=end(explode('.',$main.$file));
        switch ($extension) {
            case "php":
            case "tpl":
                $modificationDate=date("F d Y H:i:s.",filemtime($main.$file));
                echo "<tr><td>".$main."</td><td>".$file."</td><td>".filesize($main.$file).
                    "</td><td>".$modificationDate."</td></tr>";    
                break;
            default:
                break;
        } # EO switch
    } # EO else
  } # EO while
}
?>
<table>
<tr><th>Path</th><th>Filename</th><th>Size</th><th>EditTime</th></tr>
<?php
readDirs($path);
?>
</table>

