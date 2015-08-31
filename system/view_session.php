<?php
session_start();
?>
<html>
<head>
<style type="text/css">
body {
    font-family: Verdana, Geneva, sans-serif;
    font-size:14px;     
}
th {
    background-color: darkblue;
    color: white;
}
td.KEY {
    background-color: orange;
}
td.SUBKEY {
    background-color: yellow;
}
</style>
</head>
<body>
<table>
<tr><th colspan="2">SESSION Variables</th></tr>
<?php
foreach($_SESSION AS $key=>$value) {
    if (is_array($value)) {
        echo "<tr><th colspan=2>".$key."</th></tr>";   
        foreach ($value as $subkey=>$subvalue) {
            echo "<tr><td class='SUBKEY'>".$subkey."</td><td>".$subvalue."</td></tr>";    
        }
    } else {
        echo "<tr><td class='KEY'>".$key."</td><td>".$value."</td></tr>";    
    }
}
?>
</table>
<table>
<tr><th colspan="2">Cookies</th></tr>
<?php
foreach($_COOKIE AS $key=>$value) {
    if (is_array($value)) {
        echo "<tr><th colspan=2>".$key."</th></tr>";   
        foreach ($value as $subkey=>$subvalue) {
            echo "<tr><td class='SUBKEY'>".$subkey."</td><td>".$subvalue."</td></tr>";    
        }
    } else {
        echo "<tr><td class='KEY'>".$key."</td><td>".$value."</td></tr>";    
    }
}
/**
* Cleaning Up
*/
unset($_SESSION['path_actual']);
unset($_SESSION['DOCTYPE']);

?>
</table>
</body>
</html>