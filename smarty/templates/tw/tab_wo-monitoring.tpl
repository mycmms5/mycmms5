<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.WONUM}">
<input type="hidden" name="id2" value="{$data.EQNUM}">
<table width="800">
<tr><th colspan="4">{t}Downtime DATA{/t}</th></tr>
<tr><td colspan="3">{$data.TASKDESC}</td><td>{$data.REQUESTDATE}</td></tr>
<tr><th>{t}Date{/t}</th><th>{t}Breakdown date{/t}</th><th>{t}Breakdown Duration{/t}</th><th>{t}BD type{/t}</th></tr>
{foreach item=dlog from=$dlogs}
<tr><td>{$dlog[0]}</td><td>{$dlog[1]}</td><td>{$dlog[2]}</td><td>{$dlog[3]}</td></tr>
{/foreach}
</table>
 
<table width="800">
<tr><th colspan="2">{t}Reason-For-Faillure{/t}</th></tr>
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=RFF','RFF')">{t}Reason-For-Faillure{/t}</a></td>
    <td align="left"><input type="text" name="RFF" value="{$data.RFFCODE}">
    <td><input type="text" name="RFF_DESCRIPTION" value="{$data.RFFCODEDESC}"></td></tr>
<tr><td align="right">{t}Downtime{/t}</td><td>{$data.DT_DURATION} (minutes)</td></tr>    
<tr><td align="right">{t}8D reference{/t}</td>
    <td align="left"><input type="text" name="REF8D" size="4" value="{$data.REF8D}">{t}(0 for NEW){/t}</td></tr>        
<tr><td colspan="2">
    <input  class="save" type="submit"  value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>    
</form>

