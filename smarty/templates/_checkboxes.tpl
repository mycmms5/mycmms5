{foreach item=option from=$options}
    <input type="checkbox" name="{$NAME}" value="{$option[0]}">&nbsp;{$option[0]}<br>  
{/foreach}    