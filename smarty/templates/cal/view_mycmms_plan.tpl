<html>
<!-- Start of header section -->
<head>
<title>PLAN calendar for myCMMS</title>
<script type="text/javascript">
function positionPage() 
{   var position='{$smarty.session.WEBCAL_LOCATION}';
    location.hash=position;
}
function getCookie(c_name) {
    return document.cookie;
}
function setCookie(c_name,value,exdays) {
    document.cookie=c_name+"="+value;
}
</script>
<link rel="stylesheet" type="text/css" href="../styles/plancalendar_theme.css" />
<link rel="stylesheet" type="text/css" href="../styles/plancalendar_basic.css" />
<style type="text/css">{include file="wo_style.css"}</style>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<!-- Start of BODY - HEADER1 -->
<body id="year" onload="positionPage();">  
<table width="100%" class="ThemeMenubar" cellspacing="0" cellpadding="0" summary="">
<tr><td class="ThemeMenubackgr"><div id="myMenuID"></div></td>
<!-- Month selection -->
    <td class="ThemeMenubackgr ThemeMenu" align="center">
    <form action="plan_mycmms.php" method="get" name="SelectMonth" id="monthmenu"> 
        <label for="monthselect"><a href="javascript:document.SelectMonth.submit()">Month</a>:&nbsp;</label>
        <select name="date" id="monthselect" onchange="document.SelectMonth.submit()">
        {foreach item=month from=$months}
        {if $month.selected} 
            <option value="{$month.option}" selected>{$month.value}</option>
        {else}
            <option value="{$month.option}">{$month.value}</option>                    
        {/if}    
        {/foreach}
        </select>
    </form></td>  
<!-- Week selection -->    
    <td class="ThemeMenubackgr ThemeMenu" align="center">
    <form action="plan_mycmms.php" method="get" name="SelectPlan" id="planmenu">
        <label for="planselect"><a href="javascript:document.SelectPlan.submit()">Plan</a>:&nbsp;</label>
        <select name="date" id="planselect" onchange="document.SelectPlan.submit()">
        {foreach item=week from=$weeks}
        {if $week.selected} 
            <option value="{$week.option}" selected>{$week.value}</option>
        {else}
            <option value="{$week.option}">{$week.value}</option>                    
        {/if}    
        {/foreach}
        </select>
    </form></td>
<!-- Year selection -->    
    <td class="ThemeMenubackgr ThemeMenu" align="center">
    <form action="year.php" method="get" name="SelectYear" id="yearmenu">
        <label for="yearselect"><a href="javascript:document.SelectYear.submit()">Year</a>:&nbsp;</label>
        <select name="year" id="yearselect" onchange="document.SelectYear.submit()">
        {foreach item=year from=$years}
        {if $year.selected} 
            <option value="{$year.option}" selected>{$year.value}</option>
        {else}
            <option value="{$year.option}">{$year.value}</option>  
        {/if}
        {/foreach}
        </select>
    </form></td>    
    <td class="ThemeMenubackgr ThemeMenu" align="right"><a class="menuhref" title="Logout" href="login.php?action=logout">Logout:</a>&nbsp;<label>{$user}</label>&nbsp;</td>
</tr>
</table>
 
<div style="width:99%;">
<a title="{t}Previous{/t}" class='prev' href="plan_mycmms.php?date={$prevdate}" target="maintmain">
<img src="../images/previous.png" alt="{t}Previous{/t}"></a>
<a title="{t}Next{/t}" class="next" href="plan_mycmms.php?date={$nextdate}" target="maintmain">
<img src="../images/next.png" alt="{t}Next{/t}"></a>
<div class="title">
<span class="date">{$thisdate|date_format: "%d-%B (%Y)"}&nbsp;&nbsp;&nbsp; <span class="viewname">{$view_name}</span> &nbsp;&nbsp;&nbsp; {$wkend|date_format: "%d-%B (%Y)"}</span><br />
</div>
</div>

{if $planner}
<table align="center" width="400px">
<tr>
<td><a href="#" onclick="show_cookies();"><img src="../images/help.gif" width="20" alt="CHECK"></a></td>
<td><form action="plan_direct.php" method="post">
    <input type="hidden" name="ACTION" value="PLAN">
    <input type="submit" value="PLAN+"/></td>
    </form></td>
<td><form action="plan_direct.php" method="post">
    <input type="hidden" name="ACTION" value="MOVE">
    <input type="submit" value="MOVE this"/></td>
    </form></td>    
<td><form action="plan_direct.php" method="post">
    <input type="hidden" name="ACTION" value="DELETE">
    <input type="submit" value="DELETE this"/></td>
    </form></td>
<td><form action="webcal-printout.php" method="post">
    <input type="hidden" name="start" value={$thisdate}>
    <input type="hidden" name="end" value="20170716">
    <input type="submit" value="PrintOut"/></td>
    </form></td>
    
</tr>
</table>    
{/if}              

{config_load file="weblinks.conf"}
<!-- Construction of the main screen -->
<table class="main">
<tr><th class="empty" style="width:{$cw};">&nbsp;</th>
    {foreach item=header from=$headers}
    <th style="width:{$cw};" {$header.CLASS}
    {if $planner}onclick="setCookie('DAY',{$header.DAY|date_format: '%Y%m%d'});
                var x=document.getElementById('cookie_day');
                x.innerHTML={$header.DAY|date_format: '%Y%m%d'}"
    {/if}>{$header.DAY|date_format: "%d-%a"}</th>
    {/foreach}</tr>

{for $user=0 to $max_techs-1}
<tr><th class='row' style="width:{$cw};" 
        {if $planner}
        onclick="setCookie('TECH','{$techs.$user.0.UNAME}',365); 
            var x=document.getElementById('cookie_TECH');
            x.innerHTML='{$techs.$user.0.UNAME}'"
        {/if}>{$techs.$user.0.NAME}</th>
        {for $day=0 to 6}
        <td class="{$techs.$user.$day.CLASS}" style="width:{$cw};">
            {if $techs.$user.$day.EVENT}
            {foreach item=event from=$techs.$user.$day.EVENTS}
            <strong>
            <a title="Edit Menu" class="entry" id="pop{$event.ID}" href="#" 
                {if $planner}
                ondblclick="window.open('{#MYCMMS_WEBLINK#}id={$event.ID}&date={$techs.$user.$day.DATE}&user={$techs.$user.$day.UNAME}','webcal',{#MYCMMS_WINDOW_DEFS#});"
                onclick="setCookie('WO','{$event.ID}',365); 
                    var x=document.getElementById('cookie_WO');
                    x.innerHTML={$event.ID}"
                {/if}
                >
                {if $event.REGHRS gt 0}
                <div class="DONE">
                {else}
                <div class="{$event.WOSTATUS}">
                {/if}
                {$event.WONUM}&nbsp;{$event.TASKDESC}&nbsp;({$event.ID})</div>
            </a>
            </strong>
            {/foreach}            
            {/if}
        </td>{/for}
</tr>{/for}    
</table>
<hr/>
<table width="25%" align="center">
{if $smarty.session.profile==0}
<tr><th class="info">Type</th><th class="info">Value</th></tr>
<tr><th class="info">Hash:</th><td class="info">{$smarty.session.WEBCAL_LOCATION}</td></tr>
<tr><th class="info">DB_Error:</th><td class="info">{$smarty.session.PDO_ERROR}</td></tr>
{/if}
<tr><th class="info">Selected day</th><td id="cookie_day" class="info">{$smarty.cookies.DAY}</td></tr>
<tr><th class="info">Selected WO</th><td id="cookie_WO" class="info">{$smarty.cookies.WO}</td></tr>
<tr><th class="info">Selected TECH</th><td id="cookie_TECH" class="info">{$smarty.cookies.TECH}</td></tr>
</table>
</body>
</html>
