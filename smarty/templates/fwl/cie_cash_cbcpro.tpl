{if $dr.1 eq null}
<td style="background-color: orange;">{$dr.1}</td>
{else}
<td>{$dr.1}</td>
{/if}

<td>{$dr.2}</td>

{if $dr.3 gt 0}
<td style="background-color: darkgreen; color: white; text-align: right;">{$dr.3|string_format: "%2.2f"}</td>
{elseif $dr.3 eq 0}
<td style="background-color: orange; color: white; text-align: right;">{$dr.3|string_format: "%2.2f"}</td>
{elseif $dr.3 lt 0}
<td style="background-color: darkred; color: white; text-align: right;">{$dr.3|string_format: "%2.2f"}</td>
{/if}

<td>{$dr.4|nl2br}</td>
<td>{$dr.5}</td>
<td>{$dr.6}</td>
<td>{$dr.7|nl2br}</td>

{if $dr.8 ge 0}
<td style="background-color: darkgreen; color: white; text-align: right;">{$dr.8|string_format: "%2.2f"}</td>
{else}
<td style="background-color: darkred; color: white; text-align: right;">{$dr.8|string_format: "%2.2f"}</td>
{/if}

{if $dr.9 ge 0}
<td style="background-color: darkgreen; color: white; text-align: right;">{$dr.9|string_format: "%2.2f"}</td>
{else}
<td style="background-color: darkgreen; color: white; text-align: right;">{$dr.9|string_format: "%2.2f"}</td>
{/if}

{if $dr.10 ge 0}
<td style="background-color: darkgreen; color: white; text-align: right;">{$dr.10|string_format: "%2.2f"}</td>
{else}
<td style="background-color: darkred; color: white; text-align: right;">{$dr.10|string_format: "%2.2f"}</td>
{/if}

{if $dr.8 gt 0}
    {if $dr.11 gt 0.1}
    <td style="background-color: orange; color: white; text-align: right;">{$dr.11|string_format: "%2.2f"}</td>
    {elseif $dr.11 lt -0.1}
    <td style="background-color: darkred; color: white; text-align: right;">{$dr.11|string_format: "%2.2f"}</td>
    {elseif $dr.11 eq 0.0}
    <td style="background-color: darkgrey; color: black; text-align: right;">{$dr.11|string_format: "%2.2f"}</td>
    {/if}
{/if}
