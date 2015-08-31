<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="ACTION">{t}Uploading Files to Server{/t}</h1>
<form method="post" action="{$SCRIPT_NAME}" enctype="multipart/form-data">
<input type="hidden" name="STEP" value="1">
<input type="file" name="UPLOAD" style="width:500px;"></br>
<!--
<input type="color" name="COLOR"></br>
<input type="date" name="TESTDATE"></br>
-->
<input type="submit" value="Uploading">
</form>
<hr>
<!-- already linked file -->
<table width="600">
<tr><th>{t}DBFLD_filepath{/t}</th>
    <th>{t}DBFLD_filename{/t}</th>
    <th>{t}DBFLD_link{/t}</th>
    <th>{t}DBFLD_md5{/t}</th>
    <th>{t}DBFLD_filedescription{/t}</th></tr>
{foreach item=upload from=$uploads}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td><a href="../documents/upload/{$upload.filepath}{$upload.filename}" target="new">LINK</a></td>
    <td>{$upload.filename}</td>
    <td>{$upload.link}</td>
    <td>{$upload.md5}</td>
    <td>{$upload.filedescription}</td>
</tr>
{/foreach}
</table>
</body>
</html>