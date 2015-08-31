<td>{$dr.1}</td>
<td class='SPEC_{$dr.4}'>{$dr.2}</td>
<td>{$dr.3|nl2br}</td>
<td> 
{if {$dr.4} eq 'PDF'}
<a href="/HOMENET4/articles/SCANNED/0{$dr.0}.pdf">SCAN</a></td>
{else}
{$dr.4}
{/if}
</td>

