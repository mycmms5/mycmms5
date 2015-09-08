<?PHP
$stylesheet="CSS_INPUT";
require("../includes/config_mycmms.inc.php");
require("HTML/Table.php");
$Ident_1=$_REQUEST['id1'];

function get_data($Ident_1,$Ident_2) {   
    $DB=DBC::get();
    $result=$DB->query("SELECT * FROM palm_brol WHERE ID=$Ident_1");
    $data=$result->fetch(PDO::FETCH_OBJ);
    return $data; 
}
function validate_form() {
    $errors = array();
    return $errors;
}
function display_form($errors) {
global $Ident_1,$Ident_2;
if (isset($Ident_1) && $Ident_1!="new") {   
    $data=get_data($Ident_1,$Ident_2);
} 
?>
<html>
<head><title>BROL</title></head>
<body>
<h1 class="title">Brol #<?PHP echo $Ident_1; ?></h1>
<form action="<?PHP echo $_SERVER['SCRIPT NAME']; ?>" method="post" class="form">
<input type="hidden" name="id1" value="<?PHP echo $Ident_1; ?>">
<table width="600">
<tr><td class="LABEL">Brand</td>
	<td><?PHP echo create_text("Brand", 25, $data->Brand); ?></td></tr>
<tr><td class="LABEL">Object</td>
	<td><?PHP echo create_text("Objekt", 45, $data->Objekt); ?></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value="Save & Close" name="form_save">
                                   <input type="submit" class="submit" value="New" name="form_new">
                                   <input type="submit" class="submit" value="Delete" name="form_delete"></td></tr>
</table>
</form>
</html>
<?PHP
} 
function process_form($action) {   
    $DB=DBC::get();
    switch ($action) {
        case "0":
            $st=$DB->prepare("UPDATE palm_brol SET Brand=:brand,Objekt=:objekt WHERE ID=:id1");
            $st->execute(array("brand"=>$_REQUEST['Brand'],"objekt"=>$_REQUEST['Objekt'],"id1"=>$_REQUEST['id1']));
            break;
        case "1":
            $st=$DB->prepare("INSERT INTO palm_brol (ID,Brand,Objekt) VALUES (NULL,:brand,:objekt)");
            $st->execute(array("brand"=>$_REQUEST['Brand'],"objekt"=>$_REQUEST['Objekt']));
            break;
        case "-1":
            $st=$DB->prepare("DELETE FROM palm_brol WHERE ID=:id1");
            $st->execute(array("id1"=>$_REQUEST['id1']));
            break;                                
        }
}
function process_new() {
    $DB=DBC::get();
}
    
if ($_SERVER['REQUEST_METHOD']=='GET') {   
    display_form(array());      
} else {
    $errors = validate_form();
    if (count($errors)) {
        display_form($errors);  // Redisplay 
    } else {
        if (isset($_REQUEST['form_save'])) {
            process_form(0);    
        }   // Edit
        if (isset($_REQUEST['form_new'])) {
            process_form(1);
        }   // new
        if (isset($_REQUEST['form_delete'])) {
            process_form(-1);
        }
?>
<script type="text/javascript">
    opener.location.reload(true);
    self.close();
</script>
<?PHP
    }   // else
}   // End
?>
