<html>
<head>
<title></title>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.KPI {
    font-size: 18px;
    text-align: center;
    background-color: lightgrey;
}
</style>
</head>
<body>
<h1 class="action">{t}Logbook WO Status{/t}</h1>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
<table width="1000" align="center">
<tr><td><input type="checkbox" name="LOOK_EVALUATION" checked="checked">{t}Evaluation Period{/t}</td>
    <td>{t}From{/t} : {include file="_calendar2.tpl" NAME="START" VALUE=$from} - 
        {t}Until{/t} : {include file="_calendar2.tpl" NAME="UNTIL" VALUE=$until}</td></tr>
<tr><td><input type="checkbox" name="LOOK_INCLUDE_F">{t}Exclude FINISHED{/t}</td></tr>        
<tr><td>{t}Static List{/t}</td><td colspan="2"><input type="checkbox" name="STATIC" checked="checked"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="check" value="Logboek"></td></tr>
</table>
</form>

<hr>
<h1 class="action">{t}Logbook WO flow{/t}</h1>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="2">
<table width="1000" align="center">
<tr><td><input type="checkbox" name="LOOK_EVALUATION" checked="checked">{t}Evaluation Period{/t}</td>
    <td>{t}From{/t} : {include file="_calendar2.tpl" NAME="START2" VALUE=$from} - 
        {t}Until{/t} : {include file="_calendar2.tpl" NAME="UNTIL2" VALUE=$until}</td></tr>
<tr><td>{t}Static List{/t}</td><td colspan="2"><input type="checkbox" name="STATIC"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="check" value="Logboek"></td></tr>
</table>
</form>

<hr>
<h1 class="action">{t}Daily Status{/t} {$smarty.now|date_format:'%Y-%m-%d'}</h1>
<table width="1000" align="center">
<tr><th>Request<th>Approved</th><th>waiting_Material</th><th>Prepared</th><th>PLanned</th><th colspan="2"></th></tr>
<tr><td class="KPI">{$wostatus.R}</td>
    <td class="KPI">{$wostatus.A}</td>
    <td class="KPI">{$wostatus.M}</td>
    <td class="KPI">{$wostatus.P}</td>
    <td class="KPI">{$wostatus.PL}</td>
    <td colspan="2"></td></tr>
<tr><th colspan="5"></th><th>Finished</th><th>Closed</th></tr>
<tr><td colspan="5"></td><td class="KPI">{$wostatus.F}</td><td class="KPI">{$wostatus.C}</td></tr>
<tr><th colspan="4"></th><th>PRogress (urgent work)</th><th colspan="2"></th></tr>
<tr><td colspan="4"></td><td class="KPI">{$wostatus.PR}</td><td colspan="2"></td></tr>
<tr><th>NEW</th><th colspan="4"></th><th>END</th><th></th></tr>
<tr><td class="KPI">{$wostatus.NEW}</td><td colspan="4"></td><td class="KPI">{$wostatus.END}</td><td></td></tr>    
</table>
<div class="information"><p><a {$wiki}>MediaWIKI</a></p></div>
</body>
</html>