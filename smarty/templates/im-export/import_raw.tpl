<html>
<head>
<title>Raw EXCEL data</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">Raw EXCEL data</h1>
<table>
{foreach from=$data item=row}
<tr>
{foreach from=$row item=cell}
<td>{$cell}</td>
{/foreach}
</tr>
{/foreach}
</table>
</body>
</html>