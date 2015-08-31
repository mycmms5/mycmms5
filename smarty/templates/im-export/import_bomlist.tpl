<html>
<head>
<title>IMPORT NEW EQNUM from SAP</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{$header}</h1>
<table>
<tr><th>SPARECODE</th><th>ITEMNUM</th></tr>
{foreach from=$boms item=bom}
<tr><td>{$bom.SPARECODE}</td>
    <td>{$bom.ITEMNUM}</td></tr>
{/foreach}
</table>
</body>
</html>