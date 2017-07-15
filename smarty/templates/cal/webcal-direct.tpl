<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
{include file="_jscal2.tpl"}
</head>
<body>

<table style="width:100%; border:solid;">
<tr><th colspan="2">Plan data</th></tr>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="STEP" value="1">
<input type="hidden" name="WONUM" value="{$wo_data.WONUM}" />
<tr><td class="LABEL">{t}EMPCODE{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST" options=$employees NAME="EMPCODE" SELECTEDITEM=$smarty.session.webcal_user}</td></tr>
<tr><td class="LABEL">{t}WODATE{/t}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="WODATE" VALUE=$smarty.session.Ident_2}</td></tr>
<tr><td class="LABEL">{t}ESTHRS{/t}</td>
    <td><input type="text" name="ESTHRS" value="{$esthrs}"></td></tr>
<tr><td align="right" colspan="2">
    <input class="submit" type="submit" value="PLAN+" name="ACTION">
    <input class="submit" type="submit" value="MOVE this" name="ACTION">
    <input class="submit" type="submit" value="EDIT" name="ACTION">
    <input class="submit" type="submit" value="DELETE this" name="ACTION"></tr>
<tr><td class="LABEL">{t}Hours planned on this WO{/t}</td><td>{$info.planned_hours}</td></tr>    
<tr><td class="LABEL">{t}Hours executed on this WO{/t}</td><td>{$info.real_hours}</td></tr>    
<tr><td class="LABEL">{t}Today's charge for {/t}{$smarty.session.webcal_user} ({$smarty.session.Ident_2})</td><td>{$info.day_charge}</td></tr>    
</table>            
</form>

<table style="width:100%; border:solid;">
<tr><th colspan="4">WO data</th></tr>
<tr><td class="LABEL">{t}WONUM{/t}</td><td colspan="3">{$wo_data.WONUM}</td></tr>
<tr><td class="LABEL">{t}EQNUM{/t}</td><td>{$wo_data.EQNUM}</td></tr>
<tr><td class="LABEL">{t}TASKDESC{/t}</td><td>{$wo_data.TASKDESC}</td></tr>
<tr><td colspan="2">{$wo_data.TEXTS_B}</td></tr>
</table>

<table style="width:100%; border:solid;">
<tr><th>ID</th>
    <th>{t}WODATE{/t}</th>
    <th>{t}EMPCODE{/t}</th>
    <th>{t}ESTHRS{/t}</th>
    <th>{t}REGHRS{/t}</th></tr>
{foreach item=woe from=$woe_data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$woe.ID}</td><td>{$woe.WODATE}</td><td>{$woe.EMPCODE}</td><td>{$woe.ESTHRS}</td><td>{$woe.REGHRS}</td></tr>
{/foreach}
</table>

<p class="warn">{$error}</p>
</body>
</html>
