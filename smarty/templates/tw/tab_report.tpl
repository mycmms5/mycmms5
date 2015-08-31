<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<h1>View report {$report_data.REPORT} from {$report_data.ASSIGNEDTECH}</h1>
<h2>Customer: {$report_data.ORIGINATOR} / {$report_data.NAME} / {$report_data.POSTCODE}:{$report_data.CITY}</h2>
{if $format.PDF eq true}
<a href="{$report_data['report_path']}R{$report_data.REPORT}.pdf">REPORT {$report_data.REPORT} (PDF)</a>
{/if}
{if $format.JPG eq true}
<a href="{$report_data['report_path']}R{$report_data.REPORT}.jpg" target="PDFJPG">REPORT {$report_data.REPORT} (JPG)</a>
{/if}
</ul>
</body>
</form>

