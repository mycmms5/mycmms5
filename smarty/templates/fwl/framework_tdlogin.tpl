<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_exception}" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="{$authorisation_script}" method="POST" class="form">
<table align="center">
<tr><td colspan="2" align="center"><img src="{$smarty.const.LOGO_TD}" width="200"></td></tr>
<tr><td colspan="2" align="center"><h2 style="color:red;">{t}Log In{/t} {$smarty.session.system|upper}</h2></td></tr>
<tr><td colspan="2" align="center">DB:&nbsp{$smarty.const.CMMS_DB}<BR>Library:&nbsp{$smarty.const.CMMS_LIB}</td></tr>
<tr><td align="center">Login:</td><td align="center">Password:</td></tr>
<tr><td><input type="text" name="uid" class="input" size="10"></td>
    <td><input type="password" name="passwd" class="input" size="10"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="submit" value="Init this WorkStation"></td></tr>
<tr><td align="center" colspan="2"><a href="switch.php">DB-Switch</a></td></tr>
</table>
</form>
</body>
</html>
