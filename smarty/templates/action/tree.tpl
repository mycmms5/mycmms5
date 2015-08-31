{if $step eq "TOP"}
{config_load file="colors.conf"}
<html>
<head>
<title>{$labels.TableTitle}</title>
<link href="{$labels.stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$labels.stylesheet_type}" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function RefreshList() {
    window.location.reload(true);
    // document.getElementById('maintmain').contentWindow.location.reload(); 
}
</script>
</head>
<body>
<table width="{$labels.TableWidth}" cellspacing="0" cellpadding="6">
<tr bgcolor="{#TREE_BGCOLOR#}"><td width="110"><img src="../../images/tree.gif" width="30" alt="" valign="middle" /></td>
    <td><h1>{$labels.TableTitle} - {$tree_table}</h1></td></tr>
</table>
<table width="{$labels.TableWidth}" cellpadding="4" cellspacing="0">
<tr bgcolor="{#TREE_BGCOLOR#}"><td align="center">
<form action="{$SCRIPT_NAME}"><td align="left">
<input type="text" name="ROOT" value="{$rooteqnum}">&nbsp;<input type="submit" name="SET" value="Set ROOT">
<img src="../../images/refresh.png" width="25" onclick="RefreshList();" />
</form></td>
<td>
    <a href="index.php?shownode={$rooteqnum}"><img src="../../images/locate.png" alt="Locate"></a>
    <a href="index.php?expand=all"><img src="../../images/expand.png" alt="Expand All Threads"></a>
    <a href="index.php?collapse=all"><img src="../../images/collapse.png" alt="Collapse All Threads"></a></td></tr>
</table>
<table width="{$labels.TableWidth}">
{/if}
<!-- LINE formatting in individual files -->

<!-- Begin Bottom of Page -->
{if $step eq "BOTTOM"}
{config_load file="colors.conf"}
<table width="{$labels.TableWidth}" cellspacing="0" cellpadding="6">
<tr bgcolor="{#TREE_BGCOLOR#}"><td width="110"><img src="../../images/tree.gif" width="30" alt="" valign="middle" /></td></tr>
</table>
</body>
</html>
{/if}
