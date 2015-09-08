<html>
<!-- Start of header section -->
<head>
<title>PLAN calendar for myCMMS</title>
<script type="text/javascript" src="../libraries/cal/prototype.js"></script>
<!--
<script type="text/javascript" src="../libraries/cal/JSCookMenu.js"></script>
-->
<script type="text/javascript" src="../libraries/cal/themes/default/theme.js"></script>
<script type="text/javascript" src="../libraries/cal/util.js"></script>
<script type="text/javascript">
function positionPage() 
{   var position='{$smarty.session.WEBCAL_LOCATION}';
    location.hash=position;
}
function getCookie(c_name) {
    return document.cookie;
}
function show_cookies() {
    var COOKIES=getCookie("DAY");
    alert(COOKIES);
}
function show_cookies2() {
    var outMsg="";
    if (document.cookie == "") {
        outMsg="There are no PlanData avaiable";
    } else {
        var thisCookie=document.cookie.split("; ");
        for (var i=0; i< thisCookie.length; i++) {
            outMsg += thisCookie[i].split("=")[0] + " : " + thisCookie[i].split("=")[1] + "<br/>";
            
        }
    }
    document.getElementById("cookieData").innerHTML=outMsg;
}
function setCookie(c_name,value,exdays) {
    document.cookie=c_name+"="+value;
    show_cookies2();
}
// alert("Refresh Message");
</script>
<!-- <script type="text/javascript" src="../includes/js_cacher.php?inc=js/popups.php/true"></script> -->
<script type="text/javascript" src="../libraries/cal/popups.js"></script>
<link rel="stylesheet" type="text/css" href="../styles/plancalendar_theme.css" />
<link rel="stylesheet" type="text/css" href="../styles/plancalendar_basic.css" />
<style type="text/css">{include file="wo_style.css"}</style>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<!-- Start of BODY - HEADER1 -->
<body id="year" onload="cmDraw( 'myMenuID', myMenu, 'hbr', cmTheme, 'Theme' ); positionPage();">  
<table width="100%" class="ThemeMenubar" cellspacing="0" cellpadding="0" summary="">
<tr><!-- Month selection -->
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
    </tr>
</table>
 
<div style="width:99%;">
<a title="{t}Previous{/t}" class='prev' href="plan_mycmms.php?date={$prevdate}" target="maintmain">
<img src="../images/leftarrowsmall.gif" alt="{t}Previous{/t}"></a>
<a title="{t}Next{/t}" class="next" href="plan_mycmms.php?date={$nextdate}" target="maintmain">
<img src="../images/rightarrowsmall.gif" alt="{t}Next{/t}"></a>
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
    </form></td></tr>
</table>    
{/if}              

{config_load file="weblinks.conf"}
{assign var="popup" value=-1}

<!-- Construction of the main screen -->
<table class="main">
<tr><th class="empty" style="width:{$cw};">&nbsp;</th>
{foreach item=header from=$headers}
<th style="width:{$cw};" {$header.CLASS}
{if $planner}onclick="setCookie('DAY',{$header.DAY|date_format: '%Y%m%d'})"{/if}
    >{$header.DAY|date_format: "%d-%a"}</th>
{/foreach}    
</tr>
{for $user=0 to $max_techs-1}
<tr>
    <th class='row' style="width:{$cw};" 
        {if $planner}
        onclick="setCookie('TECH','{$techs.$user.0.UNAME}',365)"
        {/if}
        >{$techs.$user.0.NAME}
    </th>
    {for $day=0 to 6}
    <td class="{$techs.$user.$day.CLASS}" style="width:{$cw};">
<!--    <a title="New Entry" href="#" onclick="window.open('{#MYCMMS_WEBLINK#}?id=5','webcal',{#MYCMMS_WINDOW_DEFS#});"> 
        <img src="images/new.gif" class="new" alt="New Entry"></a> -->
        {if $techs.$user.$day.EVENT}
        {foreach item=event from=$techs.$user.$day.EVENTS}
        {$popup=$popup+1}
        <strong>
        <a title="View this event" class="entry" id="pop{$event.ID}" href="#" 
            {if $planner}
            ondblclick="window.open('{#MYCMMS_WEBLINK#}id={$event.ID}&date={$techs.$user.$day.DATE}&user={$techs.$user.$day.UNAME}','webcal',{#MYCMMS_WINDOW_DEFS#});"
            onclick="setCookie('WO','{$event.ID}',365);"
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
    </td>
    {/for}
</tr>
{/for}    
</table>

<!-- Definition of the popups -->
{foreach item=popup from=$popups}
<dl id="eventinfo-pop{$popup.pop_id}" class="popup">
<dt>Time:</dt>
<dd>{$popup.time}</dd>
<dt>Location:</dt>
<dd>{$popup.location}</dd>
<dt>Description:</dt>
<dd>{$popup.description}</dd>
</dl>
{/foreach}

<hr/>
<table>
<tr><th class="info">Type</th><th class="info">Value</th></tr>
<tr><th class="info">Hash:</th><td class="info">{$smarty.session.WEBCAL_LOCATION}</td></tr>
<tr><th class="info">PDO:</th><td class="info">{$smarty.session.PDO_ERROR}</td></tr>
<tr><th class="info">Cookie DAY</th><td class="info">{$smarty.cookies.DAY}</td></tr>
<tr><th class="info">Cookie WO</th><td class="info">{$smarty.cookies.WO}</td></tr>
<tr><th class="info">Cookie TECH</th><td class="info">{$smarty.cookies.TECH}</td></tr>
</table>
</body>
</html>
