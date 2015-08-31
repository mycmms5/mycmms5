<html>
<head>
<title></title>
</head>
<body>
<table border="solid">
<tr><th colspan="4">{t}Source data for 8D{/t} # {$data.ID}:{$data.TITLE}</th></tr>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Issue{/t}</th><th>{t}Downtime{/t}</th></tr>
{foreach item=wo from=$wo_data}
<tr><td>{$wo.WONUM}</td><td>{$wo.EQNUM}</td><td>{$wo.TASKDESC}</td><td>{$wo.DT_DURATION}</td></tr>
{/foreach}
<tr><th class="title" colspan="4">{t}8D evaluation Phase{/t}</th></tr>
<tr><th>{t}Symptoms{/t}</th><th>{t}Emergency{/t}</th><th>{t}Team{/t}</th><th>{t}Problem{/t}</th></tr>
<tr><td>{$data.D0_SYMPTOM|nl2br}</td><td>{$data.D0_EMERGENCY}</td><td>{$data.D1_TEAM}</td><td>{$data.D2_PROBLEM|nl2br}</td></tr>

<tr><th colspan="4" bgcolor="red">{t}8D Interim Action{/t}</th></tr>
<tr><th colspan="3">{t}ICA{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td colspan="3">{$data.D3_INTERIM|nl2br}</td><td>{$data.D3_DATE}</td></tr>

<tr><th colspan="4" bgcolor="orange">{t}8D Root Cause Analysis{/t}</th></tr>
<tr><th colspan="3">{t}RCA{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td colspan="3">{$data.D4_RCA|nl2br}</td><td>{$data.D4_DATE}</td></tr>

<tr><th colspan="4" bgcolor="darkgreen">{t}8D Permanent Implementation{/t}</th></tr>
<tr><th colspan="3">{t}Permanent{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td colspan="3">{$data.D5_PERMANENT|nl2br}</td><td>{$data.D5_DATE}</td></tr>

<tr><th colspan="4" bgcolor="darkgreen">{t}8D Preventive / Recommendations{/t}</th></tr>
<tr><th colspan="3">{t}Preventive{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td colspan="3">{$data.D6_PREVENT|nl2br}</td><td>{$data.D6_DATE}</td></tr>
<tr><th colspan="3">{t}Recommendations{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td colspan="3">{$data.D7_RECOMMEND|nl2br}</td><td>{$data.D7_DATE}</td></tr>

<tr><th colspan="4" bgcolor="darkgreen">{t}8D Closed{/t}</th></tr>
<tr><th colspan="4">{t}Closed on{/t}</th></tr>
<tr><td colspan="4">{$data.D8_CLOSE}</td></tr>
</table>
</body>
</html>