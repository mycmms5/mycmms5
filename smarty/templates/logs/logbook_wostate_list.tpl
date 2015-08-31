<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
table {
    width: 50%;
    text-align: center; 
}
td {
    border: 1px solid black;
    padding: 0px;
    text-align: right;
    width: 75px;
    font-size: 15px;
    color: black;
}
td.PERIOD {
    color: white;
    background-color: darkblue;
}
</style>
</head>
<body>
<h1 class="action">{t}Logbook WO Status{/t} - {$smarty.now|date_format:'%Y-%m-%d'}</h1>
<table>
<tr><th>Period</th>
    <th>R</th>
    <th>A</th>
    <th>IP</th>
    <th>M</th>
    <th>P</th>
    <th>PL</th>
    <th>PR</th>
    <th>F</th>
    <th>C</th></tr>
{foreach from=$data item=YM}
<tr><td class="PERIOD">{$YM.YM}</td>
    <td>{$YM.R}</td>
    <td>{$YM.A}</td>
    <td>{$YM.IP}</td>
    <td>{$YM.M}</td>
    <td>{$YM.P}</td>
    <td>{$YM.PL}</td>
    <td>{$YM.PR}</td>
    <td>{$YM.F}</td>
    <td>{$YM.C}</td></tr>
{/foreach}
</table>
</body>
</html>