<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
</head>
<body>
<h1 class="action">Archiving - only to be done by DB administrator</h1>

<table>
<tr><th>YEAR of Request</th><th>Number</th></tr>
{foreach from=$data item=number}
<tr><td>{$number.Year_of_REQUEST}</td><td>{$number.number_of_wo}</td></tr>
{/foreach}
</table>

<form action="{$SCRIPT_NAME}" name="CONFIRMATIONFORM" method="post">
<input type="hidden" name="STEP" value="2">
{t}Archiving all CLOSED Work Orders{/t}
<input type="submit" value="Archive">
</form>

</body>
</html>