<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>NO TITLE</title>
<meta http-equiv="content-type" content="text/html;utf-8">
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function RefreshList() {
    window.location.reload(true);
    // document.getElementById('maintmain').contentWindow.location.reload();
}
function ShowOption(id) {
    document.getElementById(id).style.display="block";
}
function HideOption(id) {
    document.getElementById(id).style.display="none";
}    
function setTitle() {
    parent.title.document.getElementById('title').innerHTML='{$smarty.session.nav}>{t}{$TableData.title}{/t}';
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_exception}" rel="stylesheet" type="text/css" />
</head>
<body onLoad="setTitle();">
<img src="../images/refresh.png" width="25" onclick="RefreshList();" />
<div class="navbar">{$navigation_bar}</div>
<table border="0" cellpadding="5">
<tr>
{foreach item=ct from=$column_titles} 
    <th>{$ct}</th>
{/foreach}
</tr>

{foreach item=dr from=$data_records}
<tr bgcolor="{cycle values="LIGHTGREY,LIGHTSTEELBLUE"}"
    onclick="ShowOption('{$dr.0}/{$dr.1}');"  
    ondblclick="HideOption('{$dr.0}/{$dr.1}');">
    <td>{$dr.0}<div id="{$dr.0}/{$dr.1}" class="hidden">
        <FORM>
        <SELECT NAME="STEP">
        {foreach item=option from=$list_options}
            <OPTION VALUE="{$option.action}?tm={$option.params}">{$option.caption}</OPTION>    
        {/foreach}            
        </SELECT>
        <INPUT TYPE="button" value="DO" onClick="openwindow_preset('{$dr.0}','{$dr.1}',this.form.STEP.value)">
        </FORM>
        </div></td>
        {include file=$template_section dr=$dr rowcolor=$rowcolor}
</tr>
{/foreach}

</table>
<img src="../images/refresh.png" width="25" onclick="RefreshList();" />
<a href="../actions/export_2_excel.php" target="excel"><img src="../images/excel.jpg" alt="EXCEL" width="25"></a>
<div class="navbar">{$navigation_bar}</div>
<p><a href="{$wiki_documentation}" target="new">documentation</a></p>
<hr>
{if $smarty.session.PDO_ERROR neq null}
<div class="error">{t}{$smarty.session.PDO_ERROR}{/t}</div>
{/if}
{if $smarty.session.profile eq 1}
<form action='edit_query.php' method='post'>
<input type='hidden' name='qry_name' value='{$smarty.session.query_name}'>
<table width="700">
<tr><td>SQL DDL: </td>
    <td><textarea name="sql_query" cols="150" rows="5">{$SQL_RAW}</textarea></td></tr>
<tr><td colspan="2"><input type='submit' name='save'></td></tr>
</table>
</form>
{if $DEBUG}
<b>Information</b><br>
<table width="700">
<tr><th colspan="2">Actual Session Data ({$session_id})</th></tr>
<tr><th>KEY</th><th>VALUE</th></tr>
{foreach key=key item=item from=$session_data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td><b>{$key}</b></td><td>{$item}</td></tr>  
{/foreach}
<tr bgcolor="cyan"><td><b>Table Mode</b></td><td>{$TableData.mode}</td></tr>
<tr bgcolor="white"><td><b>SQL</b></td><td>{$TableData.mysql}</td></tr>
<tr bgcolor="cyan"><td><b>OS Apache PHP</b></td><td>{$smarty.server.SERVER_SOFTWARE}</td></tr>
<tr bgcolor="white"><td><b>Base Template</b></td><td>{$TableData.template}</td></tr>
<tr bgcolor="cyan"><td><b>Section Template</b></td><td>{$TableData.template_section}</td></tr>
<tr bgcolor="white"><td><b>Locale</b></td><td>{$locale_data}</td></tr></table>
{/if}
{/if}
</body>
</html>