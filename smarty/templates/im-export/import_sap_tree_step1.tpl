<html>
<head>
<title>IMPORT SAP Information STEP1</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.FuncLoc {
    background-color: green;
}
td.Equipment {
    background-color: darkblue;
    color: white;
}
td.ASSY {
    background-color: orange;
}
td.PART {
    background-color: yellow;
}
</style>
</head>
<body>
<h1 class="action">{$header}</h1>
<table>
<tr><th>EQNUM</th><th>PARENT</th><th>DESC</th><th>TYPE</th></tr>
{foreach from=$data item=object}
<tr><td>{$object.EQNUM}</td>
    <td>{$object.PARENT}</td>
    <td>{$object.DESCRIPTION}</td>
    <td class="{$object.TYPE}">{$object.TYPE}</td></tr>
{/foreach}
</table>
</body>
</html>