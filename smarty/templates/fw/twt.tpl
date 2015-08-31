{config_load file="colors.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script type="text/javascript">
function RefreshParent() {
window.parent.location.href = window.parent.location.href;
}
</script>
<title>###</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="{#BODY_BGCOLOR#}" onunload="RefreshParent();">
<div class="tabs">
{foreach item=tab from=$tabs}
    {if $settings.nav_tab eq $tab.tablink}
        <a href="{$index}&nav_tab={$tab.tablink}" target="_top" class="selected">{$tab.tabheader}</a>
    {else}    
        <a href="{$index}&nav_tab={$tab.tablink}" target="_top" class="plain">{$tab.tabheader}</a>
    {/if}
{/foreach}
</div>

<div class="personalBar">{$settings.Ident_1} on {$settings.Ident_2}</div>
</body>
</html>

