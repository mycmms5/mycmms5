<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table>
<tr><th class="title" colspan="4">{t}Source data for 8D{/t}</th></tr>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Issue{/t}</th><th>{t}Downtime{/t}</th></tr>
<tr><td>{$wo_data.WONUM}</td><td>{$wo_data.EQNUM}</td><td>{$wo_data.TASKDESC}</td><td>{$wo_data.DT_DURATION}</td></tr>
<tr><th class="title" colspan="4">{t}8D evaluation Phase{/t}</th></tr>
<tr><th>{t}Symptoms{/t}</th><th>{t}Emergency{/t}</th><th>{t}Team{/t}</th><th>{t}Problem{/t}</th></tr>
<tr><td>{$data.D0_SYMPTOM|nl2br}</td><td>{$data.D0_EMERGENCY}</td><td>{$data.D1_TEAM}</td><td>{$data.D2_PROBLEM|nl2br}</td></tr>
</table>

<table>
<tr><th class="title" colspan="2">{t}8D Interim Action{/t}</th></tr>
<tr><th>{t}ICA{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td>{$data.D3_INTERIM|nl2br}</td><td>{$data.D3_DATE}</td></tr>

<tr><th class="title" colspan="2">{t}8D Root Cause Analysis{/t}</th></tr>
<tr><th>{t}RCA{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td>{$data.D4_RCA|nl2br}</td><td>{$data.D4_DATE}</td></tr>

<tr><th class="title" colspan="2">{t}8D Permanent Implementation{/t}</th></tr>
<tr><th>{t}Permanent{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td>{$data.D5_PERMANENT|nl2br}</td><td>{$data.D5_DATE}</td></tr>

<tr><th class="title" colspan="2">{t}8D Preventive / Recommendations{/t}</th></tr>
<tr><th>{t}Preventive{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td>{$data.D6_PREVENT|nl2br}</td><td>{$data.D6_DATE}</td></tr>
<tr><th>{t}Recommendations{/t}</th><th>{t}Finished on{/t}</th></tr>
<tr><td>{$data.D7_RECOMMEND|nl2br}</td><td>{$data.D7_DATE}</td></tr>

<tr><th colspan="2">{t}8D Closed{/t}</th></tr>
<tr><th colspan="2">{t}Closed on{/t}</th></tr>
<tr><td colspan="2">{$data.D8_CLOSE}</td></tr>
</table>

</body>
</html>