{debug}
<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>

{if $step eq "FORM"}
<h1 class="action">{t}Global Operation{/t}</h1>    
<h3 class="action"><u>First Step:</u> {$title}</h3>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
Give Table:&nbsp;{include file="_combobox.tpl" type="LIST" options=$tables NAME="TABLE" SELECTEDITEM=""}
<input type="text" name="FILTER" size="20" value="%">
<input type="submit" name="launch" value="Base Table">
</form>
{/if}

{if $step eq "END"}
<h1 class="action">{t}Result of Generating Tree{/t}</h1>
<p>{$title}</p>
<table>
<tr><th>{t}DBFLD_EQROOT{/t}</th><th>{t}Result{/t}</th></tr>
{foreach from=$tree_report item=eqroot}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>MCH&nbsp;{$eqroot.MCH}</td><td>has&nbsp;{$eqroot.CHILDREN}&nbsp;children</td></tr>
{/foreach}
</table>    
{/if}

{include file="fw/inputPageFooter.tpl"}
</body>
</html>
