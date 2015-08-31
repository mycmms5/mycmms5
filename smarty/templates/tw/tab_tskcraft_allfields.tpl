<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800">
<tr><th>{t}DBFLD_OPNUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_OPDESC{/t}</th>
    <th>{t}DBFLD_CRAFT{/t}</th>
    <th>{t}DBFLD_TEAM{/t}</th>
    <th>{t}DBFLD_ESTHRS{/t}</th>
    <th>{t}Action{/t}</th></tr>
{foreach item=operation from=$operations}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $operation.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$operation.ID}">
    <td>{$operation.OPNUM}</td>
    <td>{$operation.EQNUM}</td>
    <td>{$operation.OPDESC}</td>
    <td>{$operation.CRAFT}</td>
    <td>{$operation.TEAM}</td>
    <td>{$operation.ESTHRS}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr  bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$operation.ID}">
    <td><input type="text" name="OPNUM" align="left" size="4" value="{$operation.OPNUM}"></td>
    <td><input type="text" name="EQNUM" size="6" value="{$operation.EQNUM}"></td>
    <td><input type="text" name="OPDESC" size="40" value="{$operation.OPDESC}"><br>
        <textarea cols="40" rows="8" name="OPLDESC">{$operation.OPLDESC}</textarea></td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$crafts NAME="CRAFT" SELECTEDITEM=$operation.CRAFT}</td> 
    <td><input type="text" name="TEAM" align="right" size="4" value="{$operation.TEAM}"></td>
    <td><input type="text" name="ESTHRS" align="right" size="4" value="{$operation.ESTHRS}"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
    <td><input type="text" name="OPNUM" align="left" size="4"></td>
    <td><input type="text" name="EQNUM" size="6"></td>
    <td><input type="text" name="OPDESC" size="40"><br>
        <textarea cols="40" rows="8" name="OPLDESC">Long Text</textarea></td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$crafts NAME="CRAFT" SELECTEDITEM=""}</td> 
    <td><input type="text" name="TEAM" align="right" size="4"></td>
    <td><input type="text" name="ESTHRS" align="right" size="4"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>