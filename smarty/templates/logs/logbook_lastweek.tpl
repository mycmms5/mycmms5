<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>

{if $step eq "FORM"}
<h1 class="action">{t}Logbook Lookup{/t}</h1>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
<table width="1000" align="center">
<tr><td>{t}Machine{/t}</td><td>{include file="_combobox.tpl" type="LIST"  options=$machines NAME="machine" SELECTEDITEM=""}</td></tr>
<tr><td>{t}Back View{/t}</td><td><input type="text" size="3" name="preview" value="1"></td></tr>
<tr><td>{t}Static List{/t}</td><td><input type="checkbox" name="STATIC" checked="checked"></td></tr>
<tr><td colspan="2"><input type="submit" name="check" value="Logboek"></td></tr>
</table>
</form>
{/if}

{if $step eq "LIST"}
<table border="0px">
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TEXTS_B{/t}</th></tr>
{foreach item=log from=$data}
<tr bgcolor="{cycle values="`$smarty.config.LINECOLOR_ODD`,`$smarty.config.LINECOLOR_EVEN`"}">
    <td><a href="../workorders/wo_print.php?id1={$log.DBFLD_WONUM}" target="new">{$log.DBFLD_WONUM}<BR>({$log.DBFLD_WOSTATUS})</a></td>
    <td>{$log.DBFLD_EQNUM} : {$log.EQUIP_DESC} ({$log.DBFLD_ORIGINATOR} meldde op {$log.DBFLD_REQUESTDATE})<br>
        <b>{$log.DBFLD_TASKDESC}</b><br>
        {$log.DBFLD_TEXTS_B|nl2br}{$line++}<br>
<font color="red"><i>{$log.DBFLD_RFF}</i>/<i>{$log.TEXTS_PPM}</i></font></td></tr>
{foreachelse}
<tr><td colspan="2">No Items to list</td></tr>        
{/foreach}
</table>
{/if}

<div class="information"><p><a href="{$wiki}" target="new">WIKI documentation for module {$smarty.server.SCRIPT_NAME}</a></p></div>
</body>
</html>