<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
    screen.width=1500;
}
function setDELETED() {
/** Basic code from 8D-object **/
    document.MYFORM.EQNUM.style.color="orange";
    document.MYFORM.EQNUM.value='1200-VERSCHROOT';
    return true; 
/**
    document.MYFORM.D0_SYMPTOM.value='Symptoms discovered by '; 
    document.MYFORM.D0_EMERGENCY.style.color="darkblue";
    document.MYFORM.D0_EMERGENCY.value='Describe the immediate actions you took'; 
    document.MYFORM.D1_TEAM.style.color="darkblue";
    document.MYFORM.D1_TEAM.value='Give the names of the designated team';
    document.MYFORM.D2_PROBLEM.style.color="darkblue";
    document.MYFORM.D2_PROBLEM.value='Describe the exact problem where the team will be working on';
    document.MYFORM.D3_INTERIM.style.color="darkblue";
    document.MYFORM.D3_INTERIM.value='What measures did you take until the definitive implentation of a solution. Set date when implemented';
    document.MYFORM.D4_RCA.style.color="darkblue";
    document.MYFORM.D4_RCA.value='What is the Root-Cause of our problem? Set the date when there is certitude.';
    document.MYFORM.D5_PERMANENT.style.color="darkblue";
    document.MYFORM.D5_PERMANENT.value='What is the definitive solution and how will it be implemented? Set the date when implemented.';
    document.MYFORM.D6_PREVENT.style.color="darkblue";
    document.MYFORM.D6_PREVENT.value='Do you need preventive measures installed. Yes? set the date when implemented / No? say NO and set the same date as for 5';
    document.MYFORM.D7_RECOMMEND.style.color="darkblue";
    document.MYFORM.D7_RECOMMEND.value='Recommandations of the group? Other installations likely to have the same issues? Set Date when rapport was made.';
*/   
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_tw}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus();">
<form method="post" class="form" name="MYFORM" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.EQNUM}">
<input type="hidden" name="EQROOT_OLD" value="{$data.EQROOT}">
<input type="hidden" name="BOM" value="{$data.SPARECODE}">
<table width="800">
<tr><td class="LABEL">{t}EQROOT{/t}&nbsp;</td>
    <td colspan="2" align="left"><input type="text" name="EQROOT" size="75" value="{$data.EQROOT}"></br>
    <b>{$data.EQROOT_DESC}</b>&nbsp;(postid:&nbsp;{$data.parent})</td></tr>
<tr><td class="LABEL">{t}EQNUM{/t}</td>
    <td align="left"><input type="text" name="EQNUM" id="EQNUM" value="{$data.EQNUM}" size="50"</b>&nbsp;({$data.postid})&nbsp;NEW&nbsp;<input type="checkbox" name="NEW"></br>
        <input type="text" size="50" name="DESCRIPTION" value="{$data.DESCRIPTION}">&nbsp;<input type="text" size="4" name="EQORDER" value="{$data.EQORDER}"></td></tr>
<tr><td class="LABEL">{t}Object Type{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST" options=$eqtypes NAME="EQTYPE" SELECTEDITEM=$data.EQTYPE}</td></tr>
<tr><td class="LABEL">{t}SAP Type{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$floc NAME="EQFL" SELECTEDITEM=$data.EQFL}&nbsp;children?&nbsp;<input type="text" size="5" name="children" value="{$data.children}"></td></tr>
<tr><td class="LABEL">{t}Cost Center / Unit{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$ccs NAME="COSTCENTER" SELECTEDITEM=$data.COSTCENTER}&nbsp;
                     {include file="_combobox.tpl" type="LIST"  options=$units NAME="unit" SELECTEDITEM=$data.unit}</td>
    </tr>
<tr><td class="LABEL">{t}SPARECODE{/t}</td>
    <td colspan="2"><b>{$data.SPARECODE}</b></td></tr>
<tr><td class="LABEL">WinCC tagname</td><td><input type="text" name="SCADA" value="{$data.SCADA}">{$wincc}</b></td></tr>
<tr><td class="LABEL">{t}SAFETYNOTE{/t}</td>
    <td colspan="2"><textarea name="SAFETYNOTE" cols="60" rows="10">{$data.SAFETYNOTE}</textarea></td></tr>

<tr><td colspan="2"><input type="submit" class="MYCMMS" value="{t}Save{/t}" name="form_save">
                    <input type="submit" class="MYCMMS" value="{t}Close{/t}" name="close"></td></tr>
</form>
<tr><td colspan="2"><button onclick="setDELETED();">VERSCHROOT</button></td></tr>
</table>
{if $children}
<table>
<tr><th>Child</th><th>Child ID</th><th>Description</th><th>Order</th><th>parent ID</th><th>ACTION</th></tr>
{foreach item=child from=$children}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td align="left">{$child.EQNUM}</td>
    <td align="center">{$child.postid}</td>
    <td>{$child.DESCRIPTION}</td>
    <td>{$child.EQORDER}</td>
    <td align="center">{$child.parent}</td>
    <td align="center">{$child.EQFL}</td></tr>
{/foreach}
</table>
{/if}

{if $docs}
<table>
<tr><th>FLOC</th><th>PLAN</th><th>Content</th></tr>
{foreach item=doc from=$docs}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td align="left">{$doc.link}</td>
    <td align="left">{$doc.filename}</td>
    <td align="left">{$doc.filedescription}</td></tr>
{/foreach}
</table>
{/if}