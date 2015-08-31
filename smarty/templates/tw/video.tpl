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
<link href="{$stylesheet_extra}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="700" align="center">
<tr><th colspan="2">Video {$data.VideoID}</th></tr>
<form action="{$SCRIPT_NAME}" method="post" class="form" name="guarantee">
<input type="hidden" name="id1" value="{$ID}">
<tr><td align="Right">Title</td>
    <td><input type="text" name="title" size="50" value="{$data.title}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">Director</td>
    <td><input type="text" name="director" size="20" value="{$data.director}"></td></tr>
<tr><td align="right">Actors<br />(Use ; as separator)</td>
    <td><textarea name="actors" cols="80" rows="4">{$data.actors}</textarea></td></tr>
<tr><td align="right">Comment</td>
    <td><textarea name="comment" cols="80" rows="8">{$data.comment}</textarea></td></tr>
<tr><td align="right" class="SPEC_{$data.category}">Category</td>
    <td><input type="text" name="category" size="50" value="{$data.category}"></td></tr>
<tr><td align="right">recorded</td>
    <td><input type="text" name="recorded" size="4" value="{$data.recorded}"></td></tr>
<tr><td align="right"># DVD</td>
    <td><input type="text" name="SubID" size="4" value="{$data.SubID}"></td></tr>
<tr><td align="right">Storage (HAMA,MAP,BOX,PC)</td>
    <td><input type="text" name="storage" size="10" value="{$data.storage}"></td></tr>
<tr><td align="right"># HAMA</td>
    <td><input type="text" name="HAMA" size="4" value="{$data.HAMA}"></td></tr>
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
