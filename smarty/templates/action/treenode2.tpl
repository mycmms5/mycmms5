{config_load file="colors.conf"}

{if $settings.depth > -1}
<tr><td bgcolor="{cycle values="{#TREE_LINECOLOR_ODD#},{#TREE_LINECOLOR_EVEN#}"}">

{for $var=0 to $settings.depth}
<img src='../../images/spacer.gif' height='22' width='22' alt='' valign='bottom' />
{/for}
 
{if $settings.subexpand}
<a href='index.php?collapse={$data.ID}#{$data.ID}'><img src='../../images/minus.gif' valign='bottom' height='22' width='22' alt='Collapse Thread' border='0' /></a>
{elseif $settings.subnoexpand}
<a href='index.php?expand={$data.ID}#{$data.ID}'><img src='../../images/plus.gif' valign='bottom' height='22' width='22' alt='Expand Thread' border='0' /></a>
{else}
<img src='../../images/spacer.gif' height='22' width='22' alt='' valign='bottom' />
{/if}
     <a name="{$data.ID}"></a>{$data.KEY}
     <image src="../../images/view-edit.png"         
        onclick="javascript:window.open('{$data.function_edit}','_blank',
        'toolbar=no,location=no, directories=no, status=yes, menubar=no, scrollbars=yes, resizable=yes, titlebar=no, copyhistory=yes, width=1200, height=800')" align="right" height="20px">
     <image src="../../images/action.jpg"    
        onclick="javascript:window.open('{$data.function_print}','_blank',
        'toolbar=no,location=no, directories=no, status=yes, menubar=no, scrollbars=yes, resizable=yes, titlebar=no, copyhistory=yes, width=300, height=300')" align="right" height="20px"></td>
    <td class="{$data.KEY_TYPE}">{$data.KEY_DESCRIPTION}</td></tr>

{/if} 

