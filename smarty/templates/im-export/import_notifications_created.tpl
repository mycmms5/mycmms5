<table>
<tr><th>{t}CT{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_PRIORITY{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th><th>{t}DBFLD_COMPLETIONDATE{/t}</th><th>{t}DBFLD_RFF{/t}</th></tr>
{foreach from=$notifications item=notification}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$notification.ct}</td>
    <td>{$notification.eqnum}</td>
    <td>{$notification.notification}<br>{$notification.lnotification|nl2br}</td>
    <td>{$notification.notiftype}</td>
    <td>{$notification.notifdate}</td>
    <td>{$notification.notifdate_end}</td>
    <td>{$notification.rff}</td></tr>
{/foreach}
</table>
</body>
</html>