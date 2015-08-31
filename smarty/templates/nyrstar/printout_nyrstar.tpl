{include file="printout_header.tpl"}
<style type="text/css">
td.PRIO_0 {
    background-color: red;
}
td.PRIO_1  {
    background-color: orange;
}
td.PRIO_2 {
    background-color: green;
}
</style>
<body>
<table>
<tr><td colspan="2" bgcolor="red"><b>{$object_main_data.EQNUM}</b> - <i>{$object_main_data.DESCRIPTION}</i></td></tr>
<tr><td><B>{$smarty.config.IS_EQTYPE}</B></td><td>{$object_main_data.EQTYPE}</td></tr>
<tr><td><B>{$smarty.config.IS_SPARECODE}</B></td><td>{$object_main_data.SPARECODE}</td>
<tr><td>{$object_main_data.SAFETYNOTE|nl2br}</td></tr>
</table>

{* Documentation *}
{* Components *}                                      
{* spares *}
<table>
<tr><th>BOM</th><th>{t}DBFLD_ITEMNUM{/t}<BR>MAPICS</th><th>{t}DBFLD_DESCRIPTION{/t}</th><th>{t}Q12{/t}</th><th>{t}Q13{/t}</th><th>{t}Q14{/t}</th><th>VALUE 2014</th></tr>
{foreach item=spare from=$spares}
<tr><td>{$spare.BOM}</td><td>{$spare.ITEMNUM}<br><b>{$spare.MAPICS}</b></td><td>{$spare.DESCRIPTION}</td>
<td align="center">{$spare.Q12}</td>
<td align="center">{$spare.Q13}</td>
<td align="center">{$spare.Q14}</td>
<td align="right">{$spare.VALUE|string_format:"%.2f"}</td></tr>
{/foreach}
</table>
{* status *}
<!--
<table>
<tr><th>{t}DBFLD_STATUS_GEO{/t}</th><th>{t}DBFLD_STATUS_TECH{/t}</th><th>{t}DBFLD_STATUS_SAFETY{/t}</th></tr>
<tr><th colspan="3">{t}DBFLD_INTERVENTION{/t}</th></tr>
<tr><th colspan="2">{t}DBFLD_SCHEDSTARTDATE{/t}</th><th>{t}DBFLD_DURATION{/t}</th></tr>
{foreach item=state from=$status}
<tr><td>{$state.STATUS_GEO}</td><td>{$state.STATUS_TECH}</td><td>{$state.STATUS_SAFETY}</td></tr>
<tr><td colspan="3">{$state.INTERVENTION|nl2br}</td></tr>
<tr><td colspan="2">{$state.SCHEDSTARTDATE}</td><td>{$state.DURATION}</td></tr>
{/foreach}
</table>
-->

{* MB51 transactions *}
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DESCRIPTION{/t}</th><th>TXDATE</th><th>{t}QTY{/t}</th></tr>
{foreach item=tx from=$mb51}
<tr><td>{$tx.NUMISSUEDTO}</a></td>
    <td>{$tx.ITEMNUM}</td>
    <td>{$tx.ITEMDESC}</td>
    <td>{$tx.ISSUEDATE|date_format:"%Y-%B-%d"}</td>
    <td><b>{$tx.QTY}</b><br>({$tx.AVGUNITCOST}&nbsp;EURO&nbsp;)</td></tr>
{/foreach}
</table>

{* Workorders *}
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th><th>{t}DBFLD_PRIORITY{/t}</th></tr>
{foreach item=workorder from=$workorders}
<tr><td>{$workorder.WOPREV}</a></td>
    <td>{$workorder.TASKDESC}</td>
    <td>{$workorder.REQUESTDATE|date_format:"%Y-%B-%d"}</td>
    <td class='PRIO_{$workorder.PRIO}'>{$workorder.PRIO}</td></tr>
{/foreach}
</table>

</body>
</html>