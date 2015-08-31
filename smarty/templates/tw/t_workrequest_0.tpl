<!--
CVS
$Id: tab_wr-basic0.tpl,v 1.3 2013/05/12 08:23:42 werner Exp $
$Source: /var/www/cvs/mycmms40/mycmms40/smarty/templates/tab_wr-basic0.tpl,v $
$Log: tab_wr-basic0.tpl,v $
Revision 1.3  2013/05/12 08:23:42  werner
Minor

Revision 1.2  2013/04/18 07:25:11  werner
Inserted CVS variables Id,Source and Log

-->
<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_tw}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="WOPREV" value="0" />
<input type="hidden" name="EXPENSE" value="MAINT" />
<!--
<input type="hidden" name="WOTYPE" value="REPAIR" />
-->
<table width="800">
<tr><td class="LABEL" width="30%">{t}DBFLD_TASKDESC{/t}</td>
    <td><textarea name="TASKDESC" id="TASKDESC" cols="80" rows="2">{$data.TASKDESC}</textarea></td></tr>
<tr><td class="LABEL">{t}DBFLD_ORIGINATOR{/t}</td>
    <td>{$smarty.session.user}</td></tr>
<tr><td class="LABEL">{t}DBFLD_PRIORITY{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$priorities NAME="PRIORITY" SELECTEDITEM=$data.PRIORITY}</td></tr>
    </td></tr>
<tr><td class="LABEL">{t}DBFLD_WOTYPE{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$wotypes NAME="WOTYPE" SELECTEDITEM=$data.WOTYPE}</td></tr>
    </td></tr>
<tr><td class="LABEL">{t}DBFLD_REQUESTDATE{/t}</td>
    <td>{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}</td></tr>
<tr><td class="LABEL"><a href="javascript://" onClick="treewindow('../actions/tree/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}"><input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td></tr>
<!--
<tr><td align="right"><a href="javascript:window.open('../libraries/tree_equip_select.php',
    'select_equip',
    'toolbar=no,location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, titlebar=no, copyhistory=yes, width=700, height=800');">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}">&nbsp;
        <input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td></tr>    
-->        
<tr><td colspan="2">    
    <input class="submit" type="submit" value="{t}Save{/t}" name="form_save"></td></tr>
</table>
</form>
