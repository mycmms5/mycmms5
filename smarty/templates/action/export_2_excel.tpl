<html>
<head>
<title>Export Query to EXCEL#query_name</title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
window.focus();}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<h1 class="title">{t}Exporting query data to EXCEL file{/t}#{t}{$session.query_name}{/t}</h1>        
<form method="post" class="form" name="treeform" action="query_2_excel.php">
<input type="hidden" name="query_name" value="{$query_name}">
<table>
{foreach name=outer item=metatag from=$meta}
<tr bgcolor="{cycle values="#FFFFFF,#DDDDDD"}">
{foreach key=key item=item from=$metatag}
    {if $key eq "native_type"}
    <td>{$item}</td>
    {/if}
    {if $key eq "name"}
    <td>{$item}</td>
    {/if}
{/foreach}        
</tr>
{/foreach}
</table>

<table>
{foreach item=message from=$messages}
    <tr bgcolor="{cycle values="#FFFFFF,#DDDDDD"}"><td>{$message.DATE}</td>
    <td>{$message.MSG}</td></tr>
{/foreach}
</table>

<a href="{$excel_filename}" target="output">view EXCEL</a>
{include file="_wikilink.tpl" WIKIPage=$wikipage}
</body>
</html>
