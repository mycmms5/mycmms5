<!--
Formatting works as follows:
Blank cells to show the depth / Keyfield / remaining blank cells / Description
Only for root 
-->
{config_load file="colors.conf"}
<tr bgcolor="{cycle values="{#TREE_LINECOLOR_ODD#},{#TREE_LINECOLOR_EVEN#}"}">
{if $settings.depth >0}
<td colspan="{$settings.depth}"></td>
{/if}
<td><a name="{$data.ID}">
{if $settings.subexpand}
<a href='index.php?collapse={$data.ID}#{$data.ID}'><img src='../../images/minus.gif' valign='bottom' height='22' width='22' alt='Collapse Thread' border='0' /></a>
{elseif $settings.subnoexpand}
<a href='index.php?expand={$data.ID}#{$data.ID}'><img src='../../images/plus.gif' valign='bottom' height='22' width='22' alt='Expand Thread' border='0' /></a>
{else}
<img src='../../images/spacer.gif' height='22' width='22' alt='' valign='bottom' />
{/if}
{* return_values.php?tree={$data.tree}&ID={$data.EQNUM}&ID_DESC={$data.EQNUM_DESCRIPTION} *}
<a name="{$data.ID}"><a href="{$data.function}" target="print">{$data.KEY}</a></td>
<td colspan="{7-$settings.depth}"></td>
<td class="{$data.KEY_TYPE}">{$data.KEY_DESCRIPTION}</td></tr>

