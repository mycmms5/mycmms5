<td style="background-color: lightgrey; color: black; text-align: right;">{$dr.1}</td>
<td style="text-align: right;">{$dr.2|string_format: "%.2f"}</td>
<td style="text-align: right;">{$dr.3|string_format: "%.2f"}</td>
{if $dr.4 ge 0}
<td style="background-color: green; color: black; text-align: right;">{$dr.4|string_format: "%2.f"}</td>
{else}
<td style="background-color: darkred; color: white; text-align: right;">{$dr.4|string_format: "%2.f"}</td>
{/if}

