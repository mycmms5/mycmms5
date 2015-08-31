<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="id1" value="{$data.BookID}">
<table width="800">
<tr><th colspan="2">{t}New/Edit Book{/t}</td></tr>
<tr><td align="right">{t}Author{/t}</td>
    <td align="left"><B><input type="text" name="Author" size="25" value="{$data.Author}"</B>&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">{t}Title{/t}</td>
    <td align="left"><B><input type="text" name="Title" size="40" value="{$data.Title}"</B></td></tr>
<tr><td align="right">{t}Publisher{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$publishers NAME="Publisher" SELECTEDITEM=$data.Publisher}</td></tr>
<tr><td align="right">{t}Topic{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$topics NAME="Topic" SELECTEDITEM=$data.Topic}</td></tr>
<tr><td align="right">{t}Stored @{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$stores NAME="Storage" SELECTEDITEM=$data.Storage}</td></tr>
<tr><td align="right">{t}ISBN Code{/t}</td>
    <td align="left"><B><input type="text" name="ISBN" size="25" value="{$data.ISBN}"</B></td></tr>   
<tr><td align="right">{t}Published{/t}</td>
    <td align="left"><B><input type="text" name="PublishDate" size="8" value="{$data.PublishDate}"</B></td></tr>     
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</body>
</html>