{if $dr.1 ge 1000}
    <td style="text-align: right; background-color: orange;">{$dr.1|string_format:"%.0f"}</td>
{else}
    <td style="text-align: right; background-color: green;">{$dr.1|string_format:"%.0f"}</td>
{/if}
{if $dr.2 ge 5}
    <td align="right" bgcolor="orange">{$dr.2}</td>
{else}
    <td align="right" bgcolor="green">{$dr.2}</td>
{/if}
<td>{$dr.3}</td>
