{if $type eq "LIST"}
<select name="{$NAME}">
{if $SELECTEDITEM eq ""}
    <option value="" SELECTED>{t}Undefined{/t}</option>
{/if}
{foreach item=option from=$options}
    {if $option[0] eq {$SELECTEDITEM}}
        {$selected="SELECTED"}
    {else}
        {$selected=""}
    {/if}
    <option value="{$option[0]}" {$selected}>{$option[1]}</option>
{/foreach}    
</select>
{/if}

{if $type eq "MULTIPLE"}
<select name="{$NAME}" size=3 multiple>
{foreach item=option from=$options}
    {if $option[0] eq {$SELECTEDITEM}}
        {$selected="SELECTED"}
    {else}
        {$selected=""}
    {/if}
    <option value="{$option[0]}" {$selected}>{$option[1]}</option>
{/foreach}    
</select>
{/if}

{if $type eq "NUM"}
<select name="{$NAME}">
{if $SELECTEDITEM eq ""}
    <option value="" SELECTED>{t}Undefined{/t}</option>
{/if}
{foreach item=option from=$options}
    {if $option eq {$SELECTEDITEM}}
        {$selected="SELECTED"}
    {else}
        {$selected=""}
    {/if}
    <option value="{$option}" {$selected}>{$option}</option>
{/foreach}    
</select>
{/if}