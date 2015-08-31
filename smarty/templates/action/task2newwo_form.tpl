<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Select Task to create new Workorder{/t}</h1>
<table width="600" align="center">
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
<tr><td>{t}DBFLD_TASKNUM{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$tasks NAME="TASKNUM" SELECTEDITEM=""}</td></tr>    
<tr><td colspan="2" align="left"><input type="submit" name="STEP1" value="{t}Generate Work Order{/t}"></td></tr>
</table>
</form>
<div class="information"><p><a href="{$wiki}" target="new">WIKI documentation for module {$smarty.server.SCRIPT_NAME}</a></p></div>
</body>
</html>