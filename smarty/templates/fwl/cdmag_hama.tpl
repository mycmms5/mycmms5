<td>{$dr.1}</td>
{if $dr.4 gt 260}
<td class='SPEC_UNKNOWN'><i>{$dr.2|nl2br}</i></td>
{else}
<td class='SPEC_{$dr.3}'>{$dr.2|nl2br}</td>
{/if}
<td class='SPEC_{$dr.3}'>{$dr.3}</td>
<td class='SPEC_{$dr.3}'>{$dr.4}</td>

