<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table style="width:100%; border:solid;">
<tr><th colspan="4">WO data</th></tr>
<tr><td>{t}WONUM{/t}</td><td colspan="3">{$wo_data.WONUM}</td></tr>
<tr><td>EQNUM</td><td>{$wo_data.EQNUM}</td></tr>
<tr><td>TASKDESC</td><td>{$wo_data.TASKDESC}</td></tr>
<tr><td colspan="2">{$wo_data.TEXTS_B}</td></tr>
<tr><td>{t}WOSTATUS{/t}</td><td>{$wo_data.WOSTATUS}:{$wo_data.DESCRIPTION}</td></tr>
<tr><th>{t}WODATE{/t}</th>
    <th>{t}EMPCODE{/t}</th>
    <th>{t}ESTHRS{/t}</th>
    <th>{t}REGHRS{/t}</th></tr>
{foreach item=woe from=$woe_data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$woe.WODATE}</td><td>{$woe.EMPCODE}</td><td>{$woe.ESTHRS}</td><td>{$woe.REGHRS}</td></tr>
{/foreach}
</table>
<p class="warn">{$error}</p>
</body>
</html>