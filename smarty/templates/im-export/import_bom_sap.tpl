<html>
<head>
<title>IMPORT NEW EQNUM from SAP</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.NORMAL {
    background-color: green;
}
td.ASSY {
    background-color: darkblue;
    color: white;
}
td.SUBASSY {
    background-color: orange;
}
</style>
</head>
<body>
<h1 class="action">{$header}</h1>
<table>
<tr><th>SPARECODE</th><th>ITEMNUM</th><th>TYPE</th></tr>
{foreach from=$spares item=spare}
<tr><td>{$spare.SPARECODE}</td>
    <td>{$spare.ITEMNUM}</td>
    <td class="{$spare.TYPE}">{$spare.TYPE}</td></tr>
{/foreach}
</table>
</body>
</html>