<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$ID}">
<table WIDTH="600">
<tr><td valign ="top">{t}Fault ID/Title{/t}&nbsp{$data.ID}</td>
    <td colspan="2"><input type="text" name="TITLE" size="60" value="{$data.TITLE}"></td></tr>
<tr><td>0.&nbsp{t}Symptom{/t}</td>
    <td colspan="2"><textarea cols="90" rows="3" name="D0_SYMPTOM">{$data.D0_SYMPTOM}</textarea></td></tr>
<tr><td>0.&nbsp{t}Emergency Measures{/t}</td>
    <td colspan="2"><textarea cols="90" rows="3" name="D0_EMERGENCY">{$data.D0_EMERGENCY}</textarea></td></tr>
<tr><td>1.&nbsp{t}Team Members{/t}</td>
    <td colspan="2"><textarea cols="90" rows="2" name="D1_TEAM">{$data.D1_TEAM}</textarea></td></tr>
<tr><td>2.&nbsp{t}Problem Description{/t}</td>
    <td colspan="2"><textarea cols="90" rows="2" name="D2_PROBLEM">{$data.D2_PROBLEM}</textarea></td></tr>
<tr><td>3.&nbsp{t}Interim Containment Action{/t}</td>
    <td><textarea cols="50" rows="4" name="D3_INTERIM">{$data.D3_INTERIM}</textarea></td>    
    <td><input type="checkbox" name="D3" {$status.D3}>{include file="_calendar2.tpl" NAME="D3_DATE" VALUE=$data.D3_DATE}</td></tr>
<tr><td>4.&nbsp{t}Root-Cause-Analysis{/t}</td>
    <td><textarea cols="50" rows="4" name="D4_RCA">{$data.D4_RCA}</textarea></td>    
    <td><input type="checkbox" name="D4" {$status.D4}>{include file="_calendar2.tpl" NAME="D4_DATE" VALUE=$data.D4_DATE}</td></tr>
<tr><td>5.&nbsp{t}Permanent Solution{/t}</td>
    <td><textarea cols="50" rows="4" name="D5_PERMANENT">{$data.D5_PERMANENT}</textarea></td>    
    <td><input type="checkbox" name="D5" {$status.D5}>{include file="_calendar2.tpl" NAME="D5_DATE" VALUE=$data.D5_DATE}</td></tr>
<tr><td>6&nbsp{t}Preventive Measures{/t}</td>
    <td><textarea cols="50" rows="4" name="D6_PREVENT">{$data.D6_PREVENT}</textarea></td>    
    <td><input type="checkbox" name="D6" {$status.D6}>{include file="_calendar2.tpl" NAME="D6_DATE" VALUE=$data.D6_DATE}</td></tr>
       <td><? echo create_checkbox("D6",$bD6).create_date_box("D6_DATE",date_prevent,10,$data['D6_DATE']) ?></td></tr>
<tr><td>7.&nbsp{t}Recomendations{/t}</td>
    <td><textarea cols="50" rows="4" name="D7_RECOMMEND">{$data.D7_RECOMMEND}</textarea></td>    
    <td><input type="checkbox" name="D7" {$status.D7}>{include file="_calendar2.tpl" NAME="D7_DATE" VALUE=$data.D7_DATE}</td></tr>
<tr><td>8.&nbsp{t}Close Problem{/t}</td>
    <td><input type="checkbox" name="D8" {$status.D8}>{include file="_calendar2.tpl" NAME="D8_DATE" VALUE=$data.D8_DATE}</td></tr>
<tr><td colspan="2">
    <input  class="save" type="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</body>
</html>