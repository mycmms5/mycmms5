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

<ol>
{foreach item=action from=$query}
<li>{$action}</li>
{/foreach}
</ol>

{if $smarty.session.PDO_ERROR}
<div class="error">DATABASE ERROR:&nbsp;{$smarty.session.PDO_ERROR}</div>
{/if}

</body>
</html>