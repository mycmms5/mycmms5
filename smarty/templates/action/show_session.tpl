<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="700">
<tr><th colspan="3">{$number_of_sessions} Sessions stored in DB</th></tr>
<tr><th>ID</th><th>Values</th><th>Last_Updated</th></tr>
{foreach from=$sessions item=session}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>
    {if $session.sess_id eq $session_id}
        <b>{$session.sess_id}</b>
    {else}            
        {$session.sess_id}
    {/if}
    <td>{$session.value}</td>
    <td>{$session.updated|date_format:"%d-%m %H:%M:%S"}</td>
</tr>
{/foreach}
</table>

<table width="700">
<tr><th colspan="2">Actual Session Data ({$session_id})</th></tr>
<tr><th>KEY</th><th>VALUE</th></tr>
{foreach key=key item=item from=$session_data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td><b>{$key}</b></td><td>{$item}</td></tr>  
{/foreach}
</table>
</body>
</html>