<input type="text" class="text" id="{$NAME}" name="{$NAME}" value="{$VALUE}"/>
    <img src='../images/calendar.gif' id="trigger_{$NAME}" style="cursor: pointer; border: 2px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background='green';"/>
<script type="text/javascript"> 
Calendar.setup ({   
    inputField: '{$NAME}',
    ifFormat : '%Y-%m-%d',
    button : 'trigger_{$NAME}',
    position: 'T3', 
    singleClick : true,
    showsTime : false });
</script>