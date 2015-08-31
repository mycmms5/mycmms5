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
<form action="{$SCRIPT_NAME}" name="SELECTIONFORM" method="post">
<input type="hidden" name="STEP" value="1">
{t}Archiving all Work Order information from Work requested with WOSTATUS=C (Closed){/t}<br>
<input type="submit" value="Archive">
</form>

</body>
</html>