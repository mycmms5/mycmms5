<html>
<head>
<title>PHPVC :: PHP Version Control</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />

</head>
<body>
<table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr><td class="menu"><table border="0" width="100%"><tr>

    <table width="100%" cellspacing="1" cellpadding="4" border="0">
        <tr class="smallheader"><td><table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr class="smallheader" valign="middle"><td align="left" class="smallheader"><span class="title">myCMMS file linker to object {$object}</span></td></tr>
    </table></td></tr>

    <tr class="menufoot"><td>
        <table width="100%" cellspacing="0" cellpadding="1" border="0"><tr><td colspan=2>Directory: <b>{$path}</b></td></tr>
</table>

<br/>
<table class="outline-lite" width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr><td>
    <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr class="directory">
            <th width="50%" align="left" height="23">&nbsp; <b>Filename</b></th>
            <th width="50%" align="left">&nbsp; <b>Description</b></th></tr>
        <tr class="{if $smarty.section.i.iteration is odd}item0{else}item1{/if}">
            <td><a href="{$index}?file={$path}.."><img src="../images/files/back.gif" border="0"  width="16" height="16" />&nbsp;Parent Directory/</a></td>
            <td> &nbsp; </td></tr>
{section name=i loop=$directories}
        <tr class="{if $smarty.section.i.iteration is odd}item0{else}item1{/if}">
            <td><a href="{$index}?file={$path}{$directories[i][0]}"><img src="../images/files/{$directories[i][1]}" border="0" width="16" height="16" />&nbsp;{$directories[i][0]}/</a></td>
            <td> - </td></tr>
{/section}
{section name=j loop=$files}
    <tr class="{if $smarty.section.j.iteration is odd}item0{else}item1{/if}">
        <td><a href="{$index}?file={$path}{$files[j][0]}&setlink=Y"><img src="../images/files/{$files[j][1]}" border="0" width="16" height="16" />&nbsp;{$files[j][0]}</a></td><td>{$files[j][2]}</td></tr>
{/section}
</table>

<!-- List of already linked files -->
<br/>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="directory">
    <th width="50%" align="left">&nbsp; <b>Linked Files</b></th>
    <th width="50%" align="left">&nbsp; <b>Description</b></th></tr>
{foreach item=taskdocu from=$taskdocs}
    <tr bgcolor="{cycle values="lightblue,#C0FFC0"}">
        <td class="linked"><a href="{$rootdir}{$taskdocu.filepath}">{$taskdocu.filename}</a></td>
        <td>{$taskdocu.filedescription}
            <img src="../images/text.png" alt="LINK" onclick="javascript:window.open('../_main/tabmenu.php?tm=file&filename={$taskdocu.filename}','_blank','toolbar=no,location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, titlebar=no, copyhistory=no, width=800, height=600')" align="right" height="20px"></td></tr>
{/foreach}
</table>

<!-- show DB transaction errors -->
<p>{$smarty.session.PDO_ERROR}</p>     
<div class="CVS">{$version}</div>
</body>
</html>