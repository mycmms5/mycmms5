<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.NORMAL {
    background-color: green;
}
td.ASSY {
    background-color: darkblue;
    color: white;
}
td.SUBASSY {
    background-color: orange;
}
a.HASH {
    color: white;
}
</style>
</head>
<body onload="setFocus()">
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">    
<table width="800">
<tr><th colspan="4">BOM EQNUM</th></tr>
<tr>
    <th>{t}DBFLD_ITEMNUM{/t}</th>
    <th>{t}DBFLD_ITEMDESCRIPTION{/t}</th>
    <th>{t}NEEDED{/t}</th>
    <th>{t}DBFLD_QTYREQD{/t}</th></tr>
{foreach item=bom_part from=$data_eqnum}    
<tr>
    {if $bom_part.TYPE eq 'ASSY'}
        <td class="{$bom_part.TYPE}"><a href="#{$bom_part.ITEMNUM}" class="HASH">{$bom_part.ITEMNUM}</a></td>
    {else}
        <td class="{$bom_part.TYPE}">{$bom_part.ITEMNUM}</td>
    {/if}    
    <td>{$bom_part.DESCRIPTION}</td>
    <td><input type='checkbox' name='itemnum[]' value='{$bom_part.ITEMNUM}'/></td>
    <td><input type='text' size="4" name='itemnum_needed_{$bom_part.ITEMNUM}'></td>
</tr>
{/foreach}
<tr><th colspan="4">BOM PARENT</th></tr>
{foreach item=bom_part from=$data_eqroot}    
<tr>
    {if $bom_part.TYPE eq 'ASSY'}
        <td class="{$bom_part.TYPE}"><a href="#{$bom_part.ITEMNUM}" class="HASH">{$bom_part.ITEMNUM}</a></td>
    {else}
        <td class="{$bom_part.TYPE}">{$bom_part.ITEMNUM}</td>
    {/if}    
    <td>{$bom_part.DESCRIPTION}</td>
    <td><input type='checkbox' name='itemnum[]' value='{$bom_part.ITEMNUM}'/></td>
    <td><input type='text' size="4" name='itemnum_needed_{$bom_part.ITEMNUM}'></td>
</tr>
{/foreach}
{foreach item=assy_list from=$assy_parts}
<tr><th colspan="4" id="{$assy_list.0.SPARECODE}">ASSY-{$assy_list.0.SPARECODE}</th></tr>
{foreach item=bom_part from=$assy_list}
<tr><td class="{$bom_part.TYPE}">{$bom_part.ITEMNUM}</td>
    <td>{$bom_part.DESCRIPTION}</td>
    <td><input type='checkbox' name='itemnum[]' value='{$bom_part.ITEMNUM}'/></td>
    <td><input type='text' size="4" name='itemnum_needed_{$bom_part.ITEMNUM}'></td></tr>
{/foreach}
{/foreach}
</table>
  
<input type="submit" name="pick" value="Pick Material">
</form>
<div class="CVS">{$version}</div>
