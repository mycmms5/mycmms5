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
<table width="700" align="center">
<tr><th colspan="2">Password {$data.URL}#{$data.ID}</th></tr>
<form action="{$SCRIPT_NAME}" method="post" class="form" name="guarantee">
<input type="hidden" name="id1" value="{$ID}">
<tr><td align="Right">Site / URL</td>
    <td><input type="text" name="URL" size="25" value="{$data.URL}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="Right">Username</td>
    <td><input type="text" name="Username" size="25" value="{$data.Username}"></td></tr>
<tr><td align="right">Password</td>
    <td><input type="text" name="Password" size="15" value="{$data.Password}"></td></tr>
<tr><td align="right">EMail</td>
    <td><input type="text" name="Email" size="40" value="{$data.Email}"></td></tr>
<tr><td align="right">Category</td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$categories NAME="Categories" SELECTEDITEM=$data.Categories}</td></tr>
<tr><td align="right">Site Type</td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$sitetypes NAME="SiteType" SELECTEDITEM=$data.SiteType}</td></tr>
<tr><td align="right">Memo</td>
    <td><textarea name="Memo" cols="80" rows="4">{$data.Memo}</textarea></td></tr>
<tr><td align="right">Last Accessed</td>
    <td>{$data.LastAccess|date_format:"%D"}</td></tr>
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</html>
