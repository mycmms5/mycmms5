<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>

{if $step eq "FORM"}
<form method="post" action="{$SCRIPT_NAME}" enctype="multipart/form-data">
<input type="hidden" name="STEP" value="1">
<input type="file" name="UPLOAD" style="width:1000px;"></br>
<input type="submit" value="Uploading">
</form>
<hr>
<!-- already linked file -->
<table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr><td class="menu"><table border="0" width="100%"><tr>
    <table width="100%" cellspacing="1" cellpadding="4" border="0">
        <tr class="smallheader"><td><table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr class="smallheader" valign="middle"><td align="left" class="smallheader">
        <span class="title">myCMMS uploader to object {$object}</span></td></tr>
    </table></td></tr>
    <tr class="menufoot"><td>
        <table width="100%" cellspacing="0" cellpadding="1" border="0"><tr><td colspan=2>Linked Files</td></tr>
</table>
<table width="100%">
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
{if $upload_errors.exists}<li><div class="error">ERROR file was not successfully uploaded</div></li>{/if}
{if $upload_errors.move}<li><div class="error">ERROR during upload</div></li>{/if}
{if $upload_errors.mkdir}<li><div class="error">ERROR while creating directory</div></li>{/if}
{/if}

{if $step eq "DBCHECK"}
{if $error_count}
<p>The following errors occured:</p>
<ul>{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}
<p>SHA1:&nbsp;{$sha1}</br>MD5:&nbsp;{$md5}</br>MD5:&nbsp;{$data.md5}&nbsp;(DB)</p>

<form action="{$SCRIPT_NAME}">
<input type="hidden" name="STEP" value="2">
<input type="hidden" name="filename" value="{$file_info.name}">
<input type="hidden" name="md5" value="{$md5}">
<input type="hidden" name="sha1" value="{$sha1}">
<table width="100%">
<tr><th>File STATUS</th><th>Action</th></tr>
<tr><td colspan="2">{$data.filename}</td></tr>
<tr><td colspan="2"><input type="text" name="FILE_DESCRIPTION" size="100" value="{$data.filedescription}"></td></tr>

{if $file_exists}
<tr><td>{t}DBFLD_md5{/t}</td>
    {if $data.md5 neq $md5}
        <td bgcolor="red"><b>{t}Uploaded file is different from the stored file.{/t}</br>
        {t}We will only create a link from {$data.filename} to {$smarty.session.Ident_1}{/t}</br>
        {t}Please rename the file if you want to store this version{/t}</b></td></tr>
<tr><td>Exists - link only</br>{$md5}</td><td><input type="submit" name="ACTION" value="LINK"></td></tr>
    {else}
        <td bgcolor="orange">{t}Uploaded file is identical as the stored file{/t}</td></tr>
<tr><td bgcolor="orange">{t}File exists - link only{/t}</td><td><input type="submit" name="ACTION" value="UPDATE"></td></tr>
    {/if}
{else}
<tr><td>{t}Uploaded file is unknown{/t}</td>
    <td bgcolor="green">{t}{$data.filename} will be uploaded and a link will be made{/t}</td></tr>
<tr><td bgcolor="green">{t}File is new - inserted{/t}</td><td><input type="submit" name="ACTION" value="INSERT"></td></tr>
{/if}
</table>
</form>
{/if}

{if $step eq "END"}
<h1 class="ACTION">Uploaded {$store_path}</h1>
<ul><li>Content check: {$md5}</li>
    <li>Storage path: {$sha1}</li>
    {if !$upload_errors.exists}<li><div class="error">ERROR file was not successfully uploaded</div></li>{/if}
    {if !$upload_errors.move}<li><div class="error">ERROR during upload</div></li>{/if}
    {if !$upload_errors.mkdir}<li><div class="error">ERROR while creating directory</div></li>{/if}
</ul>
{/if}

<div class="CVS">{$version}</div>
</body>
</html>