<?php
/**
* This is a generic function that calls a function + template to show extra
* information on a showed list.
* 
* @var $gtb_table->name is the keyfield for table sys_listinformation
* For older versions a check is made if this table exists, when not we return nothing
* If no records exist, the user gets an informative message.
*/
$DB=DBC::get();
$result=$DB->query("SELECT * FROM sys_listinformation WHERE name='{$this->gtb_table->name}'",PDO::FETCH_ASSOC);
if (!$result) {  return NULL;}
#DebugBreak();
if ($result->rowCount()!=0 AND $this->actualPage==0) {
    $information=$result->fetch(PDO::FETCH_ASSOC);
    require($information['function']);
    $tpl_info = new smarty_mycmms();
    $tpl_info->assign("QueryName",$this->gtb_table->name);
    $tpl_info->assign("data",$data);
    return $tpl_info->fetch($information["template"]);
} else {
    return NULL;
}
?>
