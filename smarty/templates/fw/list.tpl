<html>
<head>
<meta charset="UTF-8">
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
{foreach item=columnTitle from=$column_titles} 
    <th>{$columnTitle}</th>
{/foreach}
</tr>

{foreach item=dataRecord from=$data_records}
<tr bgcolor="{cycle values="#f2f2f2,#dbe5f1"}"
    onclick="ShowOption('{$dataRecord.0}/{$dataRecord.1}');"  
    ondblclick="HideOption('{$dataRecord.0}/{$dataRecord.1}');">
    <td>{$dataRecord.0}<div id="{$dataRecord.0}/{$dataRecord.1}" class="hidden">
        <FORM>
        <SELECT NAME="STEP">
        {foreach item=option from=$list_options}
            <OPTION VALUE="{$option.action}?tm={$option.params}">{$option.caption}</OPTION>    
        {/foreach}            
        </SELECT>
        <INPUT TYPE="button" value="DO" onClick="openwindow_preset('{$dataRecord.0}','{$dataRecord.1}',this.form.STEP.value)">
        </FORM>
        </div></td>
        {include file=$template_section dr=$dataRecord rowcolor=$rowcolor}
</tr>
{/foreach}

</table>
<img src="../images/refresh.png" width="25" onclick="RefreshList();" />
<a href="../actions/export_2_excel.php" target="excel"><img src="../images/excel.jpg" alt="EXCEL" width="25"></a>
<div class="navbar">{$navigation_bar}</div>
<!-- Extra Information -->
{$list_information}
<!-- Faults were found -->
{if $smarty.session.PDO_ERROR neq null}
<h1 class="DEBUG">PDO_ERROR</h1>
<div class="error">{t}{$smarty.session.PDO_ERROR}{/t}</div>
{/if}
<!-- You're administrator and the query can be edited -->
{if $smarty.session.profile eq 1 AND $query4edit}
{include file="fw/edit_query.tpl"}
{else}
{include file="fw/show_query.tpl"}
{/if}
<!-- You're administrator and DEBUG=ON -->
{if $smarty.session.profile eq 1 AND $DEBUG}{include file="fw/debug-info.tpl"}{/if}
<!-- Standaard Footer -->
{include file="fw/inputPageFooter.tpl"}
