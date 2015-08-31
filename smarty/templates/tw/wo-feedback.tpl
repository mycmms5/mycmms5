<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    document.treeform.COMMENT.style.background='lightblue'; 
    document.treeform.COMMENT.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.WONUM}">
<input type="hidden" name="EQNUM" value="{$data.EQNUM}"><!-- To change the Object -->
<input type="hidden" name="TASKNUM" value="{$data.TASKNUM}"><!-- To reset the Task -->
<input type="hidden" name="WOSTATUS" value="{$data.WOSTATUS}">
<input type="hidden" name="ORIGINATOR" value="{$data.ORIGINATOR}">
<input type="hidden" name="ASSIGNEDTECH" value="{$ASSIGNEDTECH}"><!-- We've logged in, so... -->
<table width="800">
<tr><th colspan="2">{t}DBFLD_WOSTATUS{/t} {$data.WOSTATUS} {t}Revision in {/t} {$data.WONEXT}</th></tr>
<tr><td class="LABEL">{t}LBLFLD_TEXTS_B{/t} (OLD)</td>
    <td>{$data.TEXTS_B|nl2br}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_ASSIGNEDTECH{/t}</td>
    <td align="center"><B>{$ASSIGNEDTECH}</B></td></tr>
<!-- Equipment Tree -->
<!-- SARALEE
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">Select equipment</a></td>
    <td><input type="text" class="text" name="EQNUM" size="25" id="EQNUM" value="{$data.EQNUM}"><br><input type="text" class="text" name="DESCRIPTION" id="DESCRIPTION" size="50" value="{$data.DESCRIPTION}"></td></tr>    
-->
<tr><td class="LABEL">{$data.EQNUM}</td>
    <td align="left">{$data.DESCRIPTION}</td></tr>    
                        
<tr><td class="LABEL">{t}LBLFLD_TEXTS_B{/t}</td>
    <td><textarea class="textarea" name="COMMENT" id="COMMENT" cols="80" rows="10"></textarea></td></tr>
<tr><td class="LABEL">{t}LBLFLD_RFFCODE{/t}</td>
    <td><textarea class="textarea" name="RFFCODE" id="RFFCODE" cols="80" rows="1">{$data.RFFCODE}</textarea></td></tr>
<tr><td class="LABEL">{t}Verbetering PPM{/t}</td>
    <td><textarea class="textarea" name="TEXTS_PPM" id="TEXTS_PPM" cols="80" rows="4">{$data.TEXTS_PPM}</textarea></td></tr>
    
<tr><td colspan="2">
<table width="600" border="solid">
<tr><td><input type="radio" name="NEXTACTION" value="INTERMEDIATE" checked/></td><td align="left">{t}Intermediate Work Status Report{/t}</td></tr>
<tr><td><input type="radio" name="NEXTACTION" value="END" /></td><td align="left">{t}Job is finished. Final Report{/t}</td></tr>
<tr><td><input type="radio" name="NEXTACTION" value="REVISION" /></td><td>{t}Job is finished and machine is running, demand for Revision{/t}<br>
    <input type="text" class="text" name="NEXTWO" id="NEXTWO" size="80" value=""></td></tr>
</table></td></tr>    
<tr><td colspan="2"><input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
                    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>

</table>
</form>
<div class="CVS">{$version}</div>