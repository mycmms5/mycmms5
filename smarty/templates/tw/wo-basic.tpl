<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<script type="text/javascript">
function getXMLHTTPRequest() {
   var req =  false;
   try {
      /* for Firefox */
      req = new XMLHttpRequest(); 
   } catch (err) {
      try {
         /* for some versions of IE */
         req = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (err) {
         try {
            /* for some other versions of IE */
            req = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (err) {
            req = false;
         }
     }
   }
   
   return req;
}

function query_tasks() {
  var theEqnum = document.getElementById('EQNUM').value;
  var thePage = 'ajax_eqnum_tasks.php';
  myRand = parseInt(Math.random()*999999999999999);
  var theURL = thePage +"?rand="+myRand+"&EQNUM="+theEqnum;
  myReq.open("GET", theURL, true);
  myReq.onreadystatechange = getTasks;
  myReq.send(null);
}
function getTasks() {
  if (myReq.readyState == 4) {
    if(myReq.status == 200) {
       result = myReq.responseText;
       document.getElementById('tasks').innerHTML = result;
    }
  } else {
    document.getElementById('tasks').innerHTML = '<img src="../images/ajax-loader.gif"/>';
  }
} // EO theTasks
function query_components() {
  var theEqnum = document.getElementById('EQNUM').value;
  var thePage = 'ajax_eqnum_components.php';
  myRand = parseInt(Math.random()*999999999999999);
  var theURL = thePage +"?rand="+myRand+"&EQNUM="+theEqnum;
  myReq.open("GET", theURL, true);
  myReq.onreadystatechange = getComponents;
  myReq.send(null);
}
function getComponents() {
  if (myReq.readyState == 4) {
    if(myReq.status == 200) {
       result = myReq.responseText;
       document.getElementById('components').innerHTML = result;
    }
  } else {
    document.getElementById('components').innerHTML = '<img src="../images/ajax-loader.gif"/>';
  }
}

var myReq = getXMLHTTPRequest(); 
</script>
{include "_jscal2.tpl"}
<!--
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
-->
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="800">
<tr><th colspan="2">{t}Workorder Request Information{/t}</td></tr>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.WONUM}">
<input type="hidden" name="OLD" value="{$data.OLD}"/>
<input type="hidden" name="OLD_COMP" value="{$data.COMPONENT}"/>
<tr><td class="LABEL">{t}LBLFLD_ORIGINATOR{/t}</td><td align="center"><B>{$data.ORIGINATOR}</B></td></tr>
<tr><td class="LABEL">{t}LBLFLD_REQUESTDATE{/t}</td><td align="center"><B>{$data.REQUESTDATE}</B></td></tr>
<tr><td valign ="top" class="LABEL">{t}Workorder Task Description{/t}</td>
    <td><textarea name="TASKDESC" cols="70" rows="3">{$data.TASKDESC}</textarea></td></tr>
<tr><th colspan="2">{t}Workorder classification{/t}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_WOPRIORITY{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST" options=$priorities NAME="PRIORITY" SELECTEDITEM=$data.PRIORITY}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_WOTYPE{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$wotypes NAME="WOTYPE" SELECTEDITEM=$data.WOTYPE}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_EXPENSE{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$budgets NAME="EXPENSE" SELECTEDITEM=$data.EXPENSE}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_PROJECTID{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$projects NAME="PROJECTID" SELECTEDITEM=$data.PROJECTID}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_SCHEDSTARTDATE{/t}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="SCHEDSTARTDATE" VALUE=$data.SCHEDSTARTDATE}</td></tr>
    
<tr><td class="LABEL">{t}Work is based on Standard Procedure{/t}</td>
    <td align="left"><B>{$data.TASKNUM}</B></td></tr>
<tr><th colspan="2">{t}LBLFLD_EQNUM{/t}</td></tr>
<!--  Old Equipment Tree  
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}"><input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td></tr>
-->
<!-- NEW Equipment Tree -->
<tr><td class="LABEL"><a href="javascript:window.open('../libraries/tree_equip_select.php',
    'select_equip',
    'toolbar=no,location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, titlebar=no, copyhistory=yes, width=700, height=800');">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}">&nbsp;
        <input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td></tr>    
<!--
<tr><td align="right">{t}Sub-Component{/t}</td>
    <td><input type="text" name="COMPONENT2" value="{$data.COMPONENT}"></td></tr>                
-->
<tr><td class="LABEL">{t}LBLFLD_PREVWO{/t}</td>
    <td align="right">{$data.PREVWO}</td></tr>
<!--
    <tr><td align="right" onclick="javascript:query_components();">{t}Components in Machine{/t}</td>
    <td><div id="components"></div></td></tr>    
<tr><td align="right" onclick="javascript:query_tasks();">{t}Available Standard Tasks{/t}</td>
    <td><div id="tasks"></div></td></tr>    
-->    
<!-- Save or Close -->
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}"  name="close"></td></tr>
</form>
</table>

