<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
    screen.width=1500;
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_tw}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus();">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.EQNUM}">
<input type="hidden" name="EQROOT_OLD" value="{$data.EQROOT}">
<input type="hidden" name="BOM" value="{$data.SPARECODE}">
<table width="800">
<tr><td class="LABEL">{t}DBFLD_EQROOT{/t}&nbsp;</td>
    <td colspan="2" align="left"><input type="text" name="EQROOT" size="75" value="{$data.EQROOT}"></br>
    <b>{$data.EQROOT_DESC}</b>&nbsp;(postid:&nbsp;{$data.parent})</td></tr>
<tr><td class="LABEL">{t}DBFLD_EQNUM{/t}</td>
    <td align="left"><input type="text" name="EQNUM" value="{$data.EQNUM}" size="50"</b>&nbsp;({$data.postid})&nbsp;NEW&nbsp;<input type="checkbox" name="NEW"></br>
        <input type="text" size="50" name="DESCRIPTION" value="{$data.DESCRIPTION}"></td></tr>
<tr><td class="LABEL">{t}Object Type{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST" options=$eqtypes NAME="EQTYPE" SELECTEDITEM=$data.EQTYPE}</td></tr>
<tr><td class="LABEL">{t}SAP Type{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$floc NAME="EQFL" SELECTEDITEM=$data.EQFL}&nbsp;children?&nbsp;<input type="text" size="5" name="children" value="{$data.children}"></td></tr>
<tr><td class="LABEL">{t}Cost Center / Unit{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$ccs NAME="COSTCENTER" SELECTEDITEM=$data.COSTCENTER}&nbsp;
                     {include file="_combobox.tpl" type="LIST"  options=$units NAME="unit" SELECTEDITEM=$data.unit}</td>
    </tr>
<tr><td class="LABEL">{t}BOM{/t}</td>
    <td colspan="2"><b>{$data.SPARECODE}</b></td></tr>
<tr><td class="LABEL">WinCC tagname</td><td><input type="text" name="SCADA" value="{$data.SCADA}">{$wincc}</b></td></tr>
<tr><td class="LABEL">{t}Safety Note{/t}</td>
    <td colspan="2"><textarea name="SAFETYNOTE" cols="60" rows="10">{$data.SAFETYNOTE}</textarea></td></tr>

<tr><td colspan="2"><input type="submit" value="{t}Save{/t}" name="form_save">
                    <input type="submit" value="{t}Close{/t}" name="close"></td></tr>
</form>
</table>
{if $children}
<table>
<tr><th>Child</th><th>Child ID</th><th>Description</th><th>parent ID</th><th>ACTION</th></tr>
{foreach item=child from=$children}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td align="left">{$child.EQNUM}</td>
    <td align="center">{$child.postid}</td>
    <td>{$child.DESCRIPTION}</td>
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