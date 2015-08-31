<html>
<head>
<title>DATA INPUT FORM</title>
<style>
body {
    font-family: Verdana, Geneva, sans-serif;
    font-size:15px; 
    margin:0px; 
    padding:0px; 
    background-color: lightgrey; }
input, text, select, textarea, datum {
    font-family: Verdana, Geneva, sans-serif; 
    font-size: 12px;
    color: black; 
    background-color: white; }  
table {
    background-color: transparent;
    border-width: thin;
    font-size:13px; } 
th {
    font-size: 12px;
    color: darkblue;
    background-color: darkgrey; }    
td {
    font-size: 12px;
    padding: 1px;
    border-width: thin;
    border: hidden; }
</style>
</head>
<body>
<form id="sampleForm" name="sampleForm" method="post" action="{$actionScript}">
<table align="center">
<tr><th>Field</th><th>Value</th></tr>
<tr><td>{$criteria1}</td><td><input type="text" name="VAR1" id="VAR1" value=""></td>
{if $criteria2 neq "N/A"}
<tr><td>{$criteria2}</td><td><input type="text" name="VAR2" id="VAR2" value=""></td>
{/if}
{if $criteria3 neq "N/A"}
<tr><td>{$criteria3}</td><td><input type="text" name="VAR3" id="VAR3" value=""></td>
{/if}
<tr><td colspan="2"><input type="submit" value="{$buttonText}"></td></tr>    
</table>
</form>
</body>
</html>
