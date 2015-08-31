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
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ID}">
<table width="800">
<tr><th colspan="3">KMS information</td></tr>
{foreach item=km from=$kms}
<tr><td>{$km.TDATE}</td><td>{$km.FIRM}</td><td>{$km.DISTANCE}</td></tr>
{/foreach}
<tr><th colspan="3">Cost information</td></tr>
{foreach item=cost from=$costs}
<tr><td>{$cost.TDATE}</td><td>{$cost.FIRM}</td><td>{$cost.EXPENSES}</td></tr>
{/foreach}
</table>
</body>
</html>