<html>
<head>
<title>Printout all current 8D Actions in PDF format</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<h1 class="title">{t}Printout all cuurent 8D Actions in PDF format{/t}</h1>        
<form method="post" class="form" name="treeform" action="8D_print2pdf.php">
<table>
<tr><th>{t}DBFLD_ID{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}Print PDF{/t}</th></tr>
{foreach item=_8D from=$data}
<tr bgcolor="{cycle values="#FFFFFF,#DDDDDD"}">
    <td>{$_8D.ID}</td><td>{$_8D.EQNUM}</td><td>{$_8D.TITLE}</td>
    <td><input type='checkbox' name='ref8D[]' value='{$_8D.ID}' checked/></td></tr>
{/foreach}
</table>
<input type="submit" class="submit" value="Printout PDF" name="form_save">
</form>
<div class="information"><p><a href="http://localhost/myCMMS_MEDIAWIKI/index.php/mycmms_interface:Printout ALL work orders" target="new">documentation</a></p></div>
</body>
</html>
