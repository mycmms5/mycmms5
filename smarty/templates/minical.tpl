<table class="minical">
<caption><a href="plan_mycmms.php?year={$thisyear}&amp;month={$thismonth}">{$monthname} {$thisyear}</a></caption>
<thead>
<tr><th class="empty">&nbsp;</th>
    <th class="weekend">Sun</th>
    <th>Mon</th>
    <th>Tue</th>
    <th>Wed</th>
    <th>Thu</th>
    <th>Fri</th>
    <th class="weekend">Sat</th>
</tr>
</thead>
<tbody>
<tr>
{foreach from=$days item=week}
<td class="weeknumber">{$day.WEEKNUM}</td>    
{foreach from=$week item=day}
    <td {if $day.WEEKDAY eq 0 OR $day.WEEKDAY eq 6}class="weekend"{/if} >
    <a href="plan_mycmms.php?date={$day.RAW|date_format: "%Y%m%d"}&year={$thisyear}">{$day.DAY}</a></td>
{/foreach}   
</tr>
{/foreach}
</tbody>
</table>
