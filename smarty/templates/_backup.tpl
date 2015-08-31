<input type="text" class="text" id="LASTPERFDATE" name="LASTPERFDATE" value="{$data.LASTPERFDATE}"/>
    <img src='../images/calendar.gif' id="trigger_LASTPERFDATE" style="cursor: pointer; border: 2px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background='green';"/>
<script type="text/javascript"> 
Calendar.setup ({   
    inputField: 'LASTPERFDATE',
    ifFormat : '%Y-%m-%d',
    button : 'trigger_LASTPERFDATE',
    align : 'Tl', 
    singleClick : true,
    showsTime : false });
</script></td>
    <td align="center"><input type="text" class="text" id="NEXTDUEDATE" name="NEXTDUEDATE" value="{$data.NEXTDUEDATE}"/>
    <img src='../images/calendar.gif' id="trigger_NEXTDUEDATE" style="cursor: pointer; border: 2px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background='green';"/>
<script type="text/javascript"> 
Calendar.setup ({   
    inputField: 'NEXTDUEDATE',
    ifFormat : '%Y-%m-%d',
    button : 'trigger_NEXTDUEDATE',
    align : 'Tl', 
    singleClick : true,
    showsTime : false });
</script>