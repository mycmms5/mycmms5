<h1 class="DEBUG">Debug Session information</h1>
<table width="700">
<tr><th colspan="2">Actual Session Data ({$session_id})</th></tr>
<tr><th>KEY</th><th>VALUE</th></tr>
{foreach key=key item=item from=$session_data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td><b>{$key}</b></td><td>{$item}</td></tr>  
{/foreach}
<tr bgcolor="lightsteelblue"><td><b>Table Mode</b></td><td>{$TableData.mode}</td></tr>
<tr bgcolor="white"><td><b>SQL</b></td><td>{$TableData.mysql}</td></tr>
<tr bgcolor="lightsteelblue"><td><b>Base Template</b></td><td>{$TableData.template_css}</td></tr>
<tr bgcolor="white"><td><b>Section Template</b></td><td>{$TableData.template_section}</td></tr>
</table>
