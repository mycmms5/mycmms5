{config_load file="colors.conf"}
<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="{#TITLE_BODY_BGCOLOR#}">
<div class="logo"><img src="{$logo}" height="45"></div>
<div class="tabs">
{foreach item=tab from=$tabs}
    {if $nav eq $tab.tab}
        <a href="../{$index}?nav={$tab.tab}" target="_top" class="selected">{t}{$tab.tabheader}{/t}</a>
    {else}    
        <a href="../{$index}?nav={$tab.tab}" target="_top" class="plain">{t}{$tab.tabheader}{/t}</a>
    {/if}
{/foreach}
</div>
<div class="personalBar">
    <div class="location" id="title"></div> 
        <div class="auth">
            {if $user eq null}
                {t}You are not logged in {/t}::<a href='{$auth}' target='maintmain'>login</a>
            {else}
                {$user}&nbsp;{t} is logged in on {/t}<b>{$DB}</b>::<a href='{$auth}' target='maintmain'>logout</a>
            {/if}
        </div>
    </div>
{include file="fw/inputPageFooter.tpl"}
