<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>

{if $step eq "FORM"}
<h1 class="action">{t}Generate Tree Levels{/t}</h1>    
<h3 class="action"><u>First Step:</u> Select the Table</h3>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
Give Table:&nbsp;{include file="_combobox.tpl" type="LIST"  options=$tables NAME="TABLE" SELECTEDITEM=""}
<input type="text" name="FILTER" size="20" value="1200-M7%">
<input type="submit" name="launch" value="Base Table">
</form>
{/if}

{if $step eq "END"}
<h1 class="action">{t}Result of Generating Tree{/t}</h1>
<p>{$title}</p>
<table>
<tr><th>{t}LEVEL{/t}</th><th>{t}Result{/t}</th></tr>
{foreach from=$levels item=level}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<td>{$level.LEVEL}</td>{$level.JUMP}<td>{$level.EQNUM}</td></tr>
{/foreach}
</table>    
{/if}

{include file="fw/inputPageFooter.tpl"}

