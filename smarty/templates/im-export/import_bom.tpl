<table>
<tr><th>{t}DBFLD_ITEMNUM{/t}</th>
    <th>{t}MAPICS{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_SPARECODE{/t}</th>
</tr>
{foreach item=bom from=$boms}
<tr><td>{$bom.ITEMNUM}</td>
    <td>{$bom.MAPICS}</td>
    <td>{$bom.EQNUM}</td>
    <td>{$bom.SPARECODE}</td>
</tr>
{/foreach}
</table>
{foreach item=error from=$errors}
<p>{$error}</p>
{/foreach}