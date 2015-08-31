<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html" />
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
{include file="_jscal2.tpl"}
<script type="text/javascript">
function toggle1_IE(source) { 
    checkboxes = document.getElementsByName('uname1[]'); 
    for(i=0;i<checkboxes.length;i++)
        checkboxes[i].checked = source.checked;
}
function toggle2_IE(source) { 
    checkboxes = document.getElementsByName('uname2[]'); 
    for(i=0;i<checkboxes.length;i++)
        checkboxes[i].checked = source.checked;
}
function toggle1(source) {
  checkboxes = document.getElementsByName('uname1[]');
  for(var i in checkboxes)
    checkboxes[i].checked = source.checked;
  return true;
}
function toggle2(source) {
  checkboxes = document.getElementsByName('uname2[]');
  for(var i in checkboxes)
    checkboxes[i].checked = source.checked;
  return true;
}

</script>
</head>
<body>
<h1 class="action">{t}Printout Worksheets{/t}</h1>
<h2 class="action">{t}Indicate WO for week planning{/t}</h2>

<form action="{$SCRIPT_NAME}" name="checkform1" method="post">
<input type="hidden" name="STEP" value="1">
<table width="50%" align="left" style="float: left;">
<tr><th>{t}Name{/t}</th>
    <th>{t}Longname{/t}</th>
    <th>{t}Print{/t}</th></tr>
{foreach item=tech1 from=$techs_flo}
<tr><td>{$tech1.uname}</td>
    <td>{$tech1.longname}</td>
    <td><input type='checkbox' name='uname1[]' value='{$tech1.uname}' /></td></tr>
{/foreach}
<tr><td colspan="3">{t}Worksheet day{/t} - {include file="_calendar2.tpl" NAME="WORKDAY1" VALUE="{$smarty.now|date_format:"%Y-%m-%d"}"}</td></tr>
<tr><td>Toggle <input type='checkbox' onClick="toggle1_IE(this)"/></td>
    <td><input type="submit" class="submit" value="{t}Printout PDF{/t}" name="form_save"></td></tr>
</form>
</table>

<form action="{$SCRIPT_NAME}" name="checkform2" method="post">
<input type="hidden" name="STEP" value="1">
<table width="50%">
<tr><th>{t}Name{/t}</th>
    <th>{t}Longname{/t}</th>
    <th>{t}Print{/t}</th></tr>
{foreach item=tech2 from=$techs_mal}
<tr><td>{$tech2.uname}</td>
    <td>{$tech2.longname}</td>
    <td><input type='checkbox' name='uname2[]' value='{$tech2.uname}' /></td></tr>
{/foreach}
<tr><td colspan="3">{t}Worksheet day{/t} - {include file="_calendar2.tpl" NAME="WORKDAY2" VALUE="{$smarty.now|date_format:"%Y-%m-%d"}"}</td></tr>
<tr><td>Toggle <input type='checkbox' onClick="toggle2_IE(this)"/></td>
    <td><input type="submit" class="submit" value="{t}Printout PDF{/t}" name="form_save"></td></tr>
</form>
</table>

</body>
</html>