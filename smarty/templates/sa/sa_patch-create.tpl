<html>
<head>
<title>Patch Create</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="patch_create.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="STEP" value="1">
<table>
<tr><th>New version</th><th>Previous version</th></tr>
<tr><td><input type="file" name="NEW" style="width:500px;"></td>
    <td><input type="file" name="PREVIOUS" style="width:500px;"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="MAKEPATCH" value="Create PatchFile"></td></tr>
</form>
</table>

</body>
</html>