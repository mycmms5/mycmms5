{config_load file="colors.conf"}
<tr bgcolor="{cycle values="{#TREE_LINECOLOR_ODD#},{#TREE_LINECOLOR_EVEN#}"}">
{if $settings.depth >0}
<td colspan="{$settings.depth}" ></td>
{/if}
<td colspan="{7-$settings.depth}">{$data.KEY}</td>
<td class="{$data.KEY_TYPE}">{$data.KEY_DESCRIPTION}</td></tr>