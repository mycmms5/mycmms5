<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="" method="post">
<input type="hidden" name="query_name" value={$query_name}>
<table align="center">
<tr><th colspan="2">{$params[0][1]}</th></tr>
<tr><td>{$params[1][1]}</TD><TD><input type="text" name="param1"/></TD></TR>
<tr><td>{$params[2][1]}</TD><TD><input type="text" name="param2"/></TD></TR>
<tr><td>{$params[3][1]}</TD><TD><input type="text" name="param3"/></TD></TR>
<tr><td colspan=2 align="center"><input type="submit" value="{t}Submit query with Parameters{/t}"></td></tr>
</table>
</form>
</body>
</html>