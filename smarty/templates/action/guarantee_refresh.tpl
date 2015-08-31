<html>
<head>
<title></title>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1> Guarantee Overview</h1>
<table>
<tr><th>Jaar</th><th>Audio</th><th>Video</th><th>PC</th><th>Software</th><th>Office</th><th>Home</th><th>Abo</th><th>Company</th><th>Totaal</th><th>Opmerkingen</th></tr>
{foreach item=year from=$data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<td style="text-align: center; font-size: 15px; color: darkblue;">{$year.Jaar}</td>
<td style="text-align: right;">{$year.Audio|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.Video|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.PC|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.Software|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.Office|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.Home|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.Abo|string_format:"%.2f"}</td>
<td style="text-align: right;">{$year.Cie|string_format:"%.2f"}</td>
<td style="text-align: right; font-size: 15px; color: red;">{$year.Total|string_format:"%.2f"}</td>
<td style="text-align: left;">{$year.text|nl2br}</td>
</tr>
{/foreach}
</table>
</form>
</html>
