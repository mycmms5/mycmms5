{foreach item=check from=$checks}
    {if $check[0] eq $check[1]}
            <input type="checkbox" name="{$NAME}" checked="checked" value="{$check[0]}">&nbsp;{$check[0]}<br>  
        {else}
            <input type="checkbox" name="{$NAME}" value="{$check[0]}">&nbsp;{$check[0]}<br>      
        {/if}    
{/foreach}    