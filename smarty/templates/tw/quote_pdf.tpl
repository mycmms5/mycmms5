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
<h1>View offer {$quote_data.OFFER} for {$quote_data.NAME}</h1>
<h2>Customer: {$quote_data.CLID} / {$quote_data.NAME}</h2>
<ul>
{foreach from=$quotes item=quote}
<li><a href="{$quote_path}{$quote}">(full name: {$quote})</a></li>
{/foreach}
</ul>
</body>
</form>

