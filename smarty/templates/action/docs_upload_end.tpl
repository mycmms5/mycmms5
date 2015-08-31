<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- already linked file -->
<table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr><td class="menu"><table border="0" width="100%"><tr>
    <table width="100%" cellspacing="1" cellpadding="4" border="0">
        <tr class="smallheader"><td><table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr class="smallheader" valign="middle"><td align="left" class="smallheader"><span class="title">myCMMS uploader to object {$object}</span></td></tr>
    </table></td></tr>
    <tr class="menufoot"><td>
        <table width="100%" cellspacing="0" cellpadding="1" border="0"><tr><td colspan=2>Linked Files</td></tr>
</table>
<table width="600">
<tr class="directory"><th>{t}DBFLD_filename{/t}</th>
    <th>{t}DBFLD_link{/t}</th>
    <th>{t}DBFLD_md5{/t}</th>
    <th>{t}DBFLD_filedescription{/t}</th></tr>
{foreach item=upload from=$uploads}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td><a href="{$upload_dir}{$upload.filepath}{$upload.filename}" target="new">{$upload.filename}</a></td>
    <td>{$upload.link}</td>
    <td>{$upload.md5}</td>
    <td>{$upload.filedescription}</td>
</tr>
{/foreach}
</table>

<ul>
<li><div class="error">{$upload_errors.upload_path}</div></li>
<li><div class="error">{$upload_errors.upload_tmp}</div></li>
{if !$upload_errors.exists}
    <li><div class="error">ERROR file was not successfully uploaded</div></li>
    <li><div class="error">{if !$upload_errors.move}ERROR during upload{else}MOVE from temp to upload succeeded{/if}</div></li>
    <li><div class="error">{if !$upload_errors.move}ERROR while creating directory{else}MKDIR {$upload.filepath} succeeded{/if}</div></li>
{/if}    
</ul>
</body>
</html>