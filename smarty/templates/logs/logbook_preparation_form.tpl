<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Logbook Preparation{/t}</h1>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
<table width="1000" align="center">
<tr><td align="right">{t}LBLFLD_ASSIGNEDBY{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="NUM"  options=$approvers NAME="ASSIGNEDBY" SELECTEDITEM=$smarty.session.user}</td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="check" value="Logboek"></td></tr>
</table>
</form>
<div class="information"><p><a {$wiki}>MediaWIKI</a></p></div>
</body>
</html>