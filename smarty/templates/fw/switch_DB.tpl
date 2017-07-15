<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>
<h1 class="action">Switch Database</h1>    
<!--
<table>
<tr><td>Select new Database</td>
    <td><form action="{$SCRIPT_NAME}" method="post">
        <input type="hidden" name="STEP" value="DB">
        {include file="_combobox.tpl" type="NUM"  options=$databases NAME="DATABASE_SWITCH" SELECTEDITEM=""}</td></tr>
<tr><td colspan="2"><input type="submit" name="Switch" value="Switch"></td></tr>
</form>
</table>
-->
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="DB">
{include file="_listRadio.tpl" options=$databases NAME="DATABASE_SWITCH" SELECTEDITEM="DEVELOPMENT"}
<input type="submit" name="Switch" value="Switch">
</form>
<hr>
<table>
<tr><th>DEFINE</th><th>Settings</th></tr>
{foreach name=outer item=setting from=$settings}
  {foreach key=key item=item from=$setting}
    <tr><td><b>{$key}</b></td><td>{$item}</td></tr>
  {/foreach}
{/foreach}
</table>
</body>
</html> 

