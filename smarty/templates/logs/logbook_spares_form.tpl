<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Logbook Lookup{/t}</h1>
<h1 class="action">{t}Select criteria (tick to activate){/t}</h1>
<table width="1000" align="center">
<tr>
<form action="{$SCRIPT_NAME}" name="treeform" method="post">
<input type="hidden" name="STEP" value="1">
    <td><input type="checkbox" name="LOOK_SAP">{t}SAP number{/t}</td>
    <td><input type="text" name="SAP" size="10"> {t}DBFLD_WONUM{/t} <input type="checkbox" name="WOP" checked></td></tr>
<tr><td><input type="checkbox" name="LOOK_TEXT">{t}Text search for Part{/t}</td>
    <td><input type="text" name="TEXT" size="25"></td></tr>
<tr><td><input type="checkbox" name="LOOK_BOM">{t}BOM{/t}&nbsp;<a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td>
    <td><input type="text" name="EQNUM" size="25"><input type="text" name="DESCRIPTION" size="35"></td></tr>  
<tr><td colspan="2" align="left"><input type="submit" name="STEP1" value="Select WO nr"></td></tr>
</table>
</form>
<div class="CVS">{$version}</div>
</body>
</html>