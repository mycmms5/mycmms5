{$ics_header|nl2br}
<hr>
<b>BEGIN:VEVENT</b>
<table>
{foreach from=$events item=event}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$event.UID}</td>
    <td>{$event.CLASS}</td>
    <td>{$event.STATUS}</td>
    <td>{$event.CONFIRMED}</td>
    <td>{$event.CREATED}</td>
    <td>{$event.DTSTART}</td>
    <td>{$event.DTEND}</td>
    <td>{$event.SUMMARY}</td>
    <td>{$event.DESCRIPTION|nl2br}</td>
</tr>    
{/foreach}
</table>
<b>END:VEVENT</b>
</body>
</html>