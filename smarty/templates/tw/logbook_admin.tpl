<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="700" align="center">
<form action="{$SCRIPT_NAME}" method="post" class="form" name="guarantee">
<input type="hidden" name="id1" value="{$ID}">
<form action="<?PHP echo $_SERVER['SCRIPT NAME']; ?>" method="post" class="form">
<input type="hidden" name="id1" value="<?PHP echo $Ident_1; ?>">
<table width="600">
<tr><th colspan="2">Logbook Admin Entry # {$ID}</th></tr>
<tr><td align="Right">Admin Log Source</td>
    <td><input type="text" name="sender" size="25" value="{$data.sender}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">Content</td>
    <td><textarea name="content" rows="3" cols="80">{$data.content}</textarea></td></tr>
<tr><td align="right">Doc.Date</td>
    <td align="center">{include file="_calendar2.tpl" NAME="docdate" VALUE=$data.docdate}</td></tr>
<tr><td align="right">Type</td>
    <td align="center">{include file="_combobox.tpl" type="LIST"  options=$types NAME="type" SELECTEDITEM=$data.type}</td></tr>
<tr><td align="right">Keep (Y/N)</td>
    <td align="center"><input type="text" name="keep" value="{$data.keep}"></td></tr>    
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</html>
