<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Select existing workorder or choose new workorder{/t} </h1>
<table width="100%">
<form action="{$SCRIPT_NAME}" name="treeform" method="post">
<input type="hidden" name="STEP" value="1">
<tr><td align="right">{t}DBFLD_TASKNUM{/t}</td>
    <td><input type="text" name="TASKNUM">&rarr;</td>  
<tr><td align="right">{t}DBFLD_WONUM{/t}</td>
    <td><input type="text" name="WONUM"></td></tr>    

<tr><td align="right"><input type="checkbox" name="new">&nbsp;{t}NEW WorkOrder{/t}</td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}"><input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}">&nbsp;<a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td></tr>

<tr><td colspan="2" align="left"><input type="submit" name="STEP1" value="{t}Copy TASK to WO{/t}"></td></tr>
</table>
</form>
<div class="information"><p><a href="{$wiki}" target="new">WIKI documentation for module {$smarty.server.SCRIPT_NAME}</a></p></div>
</body>
</html>