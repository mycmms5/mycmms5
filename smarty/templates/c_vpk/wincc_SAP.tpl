{if $dr.1 neq null}
<td class='SPEC_MOV'>{$dr.1}</td>
{else}
<td>{$dr.1}</td>
{/if}
<td>{$dr.2}</td>
{if $dr.3 eq $dr.4}
<td class="SPEC_MOV">{$dr.3}</td>
{else}
<td class="SPEC_FLOK">{$dr.3}</td>
{/if}
<td>{$dr.4}</td>



