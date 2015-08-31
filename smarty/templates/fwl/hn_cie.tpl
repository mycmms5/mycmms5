{$debug}
<td class="SPEC_{$dr.1}">{$dr.1}</td>
<td>{$dr.2}</td>
<td class='SPEC_{$dr.8}'>{$dr.3}</td>
<td class='SPEC_{$dr.8}'>{$dr.4|nl2br}</td>
{if $dr.5 ge 350}
<td bgcolor="red" align="right">{$dr.5|string_format:"%.2f"}</td>
{else}
<td align="right">{$dr.5|string_format:"%.2f"}</td>
{/if}
{if $dr.6 gt 0}
<td bgcolor="green" align="right">{$dr.6|string_format:"%.2f"}</td>
{else}
<td align="right">{$dr.6|string_format:"%.2f"}</td>
{/if}
<td align="right">{$dr.7|string_format:"%.2f"}</td>
<td class='SPEC_{$dr.8}'>{$dr.8}</td>
<td class='SPEC_{$dr.8}'>{$dr.9}</td>
<td class='SPEC_{$dr.8}'>{$dr.10}</td>
{if $dr.11 eq '2016-01-01'}
<td bgcolor="red" colspan="2">UNPAID</td>
{elseif $dr.11 eq '2999-01-01'}
<td bgcolor="orange" colspan="2">UNBILLED</td>
{else}
<td bgcolor="green">{$dr.11}</td>
<td>{$dr.12}</td>
{/if}