/*	Open a work order in a new window. If woid = "new" a new wo will open"
$Id: functions.js,v 1.4 2013/09/28 08:44:05 werner Exp $
$Source: /var/www/cvs/mycmms40/mycmms40/libraries/functions.js,v $
$Log: functions.js,v $
Revision 1.4  2013/09/28 08:44:05  werner
NEW function treewindow_x return data back to form x instead of 0

Revision 1.3  2013/06/08 11:30:44  werner
New functions:
+ openwindow_params
+ openwindow_preset

Revision 1.2  2013/04/17 06:10:25  werner
Inserted CVS variables Id,Source and Log

*/ 
$dest_window="new_window";
$secundary_window="sec_window";
$third_window="third_window";
$options="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,titlebar=no,copyhistory=yes,width=800,height=700";
$options2="toolbar=yes,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,titlebar=yes,copyhistory=yes,width=800,height=700";
$JS_equiptree="../libraries/equip_tree.php";
$PHP_OEE_tree="../actions/oeetree/index.php";
$PHP_equiptree="../actions/equiptree/index.php";

function openwindow2($id1, $id2, $php) 
{	document.title=$php;
  	window.open("./"+$php+"?id1="+$id1+"&id2="+$id2,
        $dest_window,
        $options);
}
function openwindow_params($id1, $id2, $php, $params) 
{    document.title=$php;
      window.open("./"+$php+"?tm="+$params+"&id1="+$id1+"&id2="+$id2,
        $dest_window,
        $options).focus();
}
function openwindow_preset ($id1, $id2, $php) 
{    document.title=$php;
     window.open("./"+$php+"&id1="+$id1+"&id2="+$id2,
        $dest_window,
        $options).focus();
}

/*	Secundary window for extra information
*   Unused
*/
function sec_window($id1, $id2, $php)
{	document.title = $php;
	window.open("./"+$php+"?id1="+$id1+"&id2="+$id2, $secundary_window, $options);
}
/*  Equipment Tree (JavaScript version) 	
*   Used in wo...
*   Used in objects
 */
function equipmentwindow(form_name, control_name, root)
{	document.title = "Work Order";
    root=document.forms[0].elements["EQNUM"].value;
    window.open($JS_equiptree+"?form="+form_name+"&control="+control_name+"&root="+ root,"equip_window",$options);
}
function treewindow(php,root) {   
    // form_name is always treeform
    // Control_name is predefined in:
    //  - OEE Tree (return_oee.php)
    //  - EquipTree (return_eqnum.php)
    root=document.forms[0].elements[root].value;
    window.open(php+"&root="+root,"treewindow",$options2);
}
function treewindow_x(php,root,form_num) {   
    // form_name is always treeform
    // Control_name is predefined in:
    //  - OEE Tree (return_oee.php)
    //  - EquipTree (return_eqnum.php)
    eqnum=document.forms[form_num].elements[root].value;
    window.open(php+"&root="+eqnum,"treewindow",$options2);
}
function treewindow_2(php,root) {
    root='';
    window.open(php+"&root="+root,"treewindow",$options);    
}
/*	RFF Codes per Equipment Type
*/
function rff_window(form_name,control_1,control_2,type)
{	document.title = "RFF / Equipment Type";
	window.open("../libraries/rff_tree.php?form="+form_name+"&control_1="+control_1+"&control_2="+control_2+"&eqtype="+type , "rff_window","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,titlebar=no,copyhistory=yes,width=300,height=575");
}
/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;

/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor) {
    var theCells = null;
    // 1. Pointer and mark feature are disabled or the browser can't get the row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }
    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }
    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3
    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function


