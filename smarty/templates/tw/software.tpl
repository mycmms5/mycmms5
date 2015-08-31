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
<input type="hidden" name="id1" value="{$data.ID}">
<table width="800">
<tr><th colspan="2">Software Information #{$data.ID}</th></tr>
<tr><td align="right">{t}Date{/t}</td>
    <td align="left">{include file="_calendar.tpl" NAME="date_ID" VALUE=$data.date_ID}</td></tr>
<tr><td align="right">{t}Category{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$categories NAME="category" SELECTEDITEM=$data.category}&nbsp;{$data.category}&nbsp;<input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><th align="right">RULES</th>
    <th align="left">- For SOFTWARE indicate the company<br>
        - For LOG ...<br>
        - For Information ...</th></tr>
<tr><td align="right">{t}Title{/t}</td>
    <td align="left"><input type="text" name="title" size="60" value="{$data.title}"</B></td></tr>
<tr><td align="right">{t}Content{/t}</td>
    <td align="left"><textarea cols="70" rows="15" name="content">{$data.content}</textarea></td></tr>
<tr><th align="right">RULES</th>
    <th align="left">For SW use OS,HAMA,GONE,archive and the location<br>
                    - For LOG use PAGE and page number or PDF and 0 (see link)<br>
                    - For INFO use PAGE and page number / PDF and 0 (see link)</td></tr>
<tr><td align="right">{t}Storage{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$boxes NAME="box" SELECTEDITEM=$data.box}&nbsp;
    <input type="text" name="classification" size="5" value="{$data.classification}">&nbsp;({$latest_location})</td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</body>
</html>
