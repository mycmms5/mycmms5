<html>
<head>
<title>Upload Errors</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
{if $error_count}
<p>The following errors occured:</p>
<ul>
{foreach from=$errors item=error}
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

</body>
</html>