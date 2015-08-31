<html>
<head>
<meta http-equiv='content-type' content="text/html;charset='UTF-8'">
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style>
table {
    border: solid 1px red;
}
th.TH3 {
    border: solid 1px blue;
    background-color: orange;
}
</style>
</head>
<body>

<table width="100%" border="solid">
<tr><th colspan="4" bgcolor="red">{t}Worksheet for {/t}{$tech} ({$id}) - <br>EQUIPE: ATELIER - Pause MO-A-MO</th></tr>
<tr><th class="TH3">{t}Poste{/t}</th>
    <th class="TH3">{t}Date{/t}</th>
    <th class="TH3">{t}Temps{/t}</th>
    <th class="TH3">{t}Description{/t}</th></tr>
{foreach item=job from=$data}
<tr><td>{$job.0}</td>
    <td>{$job.1}</td>
    <td>{$job.2}</td>
    <td>{$job.3}</td>
</tr>
{/foreach}
</table>

<table width="100%" border="solid">
<tr><th>{t}Comments{/t}</th><th>{t}Spare Parts{/t}</th></tr>
<tr><td>.<br>.<br>.<br></td><td>.<br>.<br>.<br></td></tr>
<tr><td>.<br>.<br>.<br></td><td>.<br>.<br>.<br></td></tr>
<tr><td>.<br>.<br>.<br></td><td>.<br>.<br>.<br></td></tr>
<tr><td>.<br>.<br>.<br></td><td>.<br>.<br>.<br></td></tr>
<tr><td>.<br>.<br>.<br></td><td>.<br>.<br>.<br></td></tr>
<tr><td>.<br>.<br>.<br></td><td>.<br>.<br>.<br></td></tr>
</table>

</body>
</html>