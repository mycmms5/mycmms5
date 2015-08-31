<html>
<head>
<title>Event_XML</title>
</head>
<body>
<table>
<tr><th>XML</th><th>MACHINE</th><th>Failure at</th></tr>
{foreach from=$events item=event}
<tr><td>{$event.XML_filename}</td><td>{$event.mch}</td><td>{$event.start}</td></tr>
{/foreach}
</table>
</body>
</html>