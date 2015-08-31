<td>{$dr.1}</td>
{if $dr.2 ge 0}
<td style="background-color: darkgreen; color: white; text-align: right;">{$dr.2|string_format: "%2.2f"}</td>
{else}
<td style="background-color: darkred; color: white; text-align: right;">{$dr.2|string_format: "%2.2f"}</td>
{/if}
<td>{$dr.3|nl2br}</td>
<td>{$dr.4}</td>
<td>{$dr.5|nl2br}</td>
