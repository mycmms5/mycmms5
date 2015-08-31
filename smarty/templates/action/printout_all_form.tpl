<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Pre-Select Equipment{/t}</h1>
<table width="700" align="center">
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
<tr><td>{t}DBFLD_EQNUM{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$lines NAME="EQNUM" SELECTEDITEM=""}</td></tr>
<tr><td colspan="2"><input type="submit" name="check" value="{t}Pre-Select Equipment{/t}"></td></tr>
</form>
</table>
</body>
</html>