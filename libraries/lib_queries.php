<?php
/**  
* Save and store SQL 
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2009
* @access  public
* @package libraries
* @subpackage SQL_library
* @filesource
*/
/**
* Retrieve query from sys_queries
* 
* @param mixed $sql_name
* @return string
*/
function get_sql($sql_name) {
    $DB=DBC::get();
    $sql_select=DBC::fetchcolumn("SELECT mysql FROM sys_queries WHERE name='$sql_name'",0);
    eval('$sql_select="'.$sql_select.'";');  
    return $sql_select;
}
function get_sql_data($sql_name) {
    $DB=DBC::get();
    $sql_select=DBC::fetchcolumns("SELECT mysql,mode,specific_attributes FROM sys_queries WHERE name='$sql_name'");
    eval('$sql_select[0]="'.$sql_select[0].'";');  
    return $sql_select;
}
/**
* Store changeable queries back into the sys_queries table.
* 
* @param mixed $sql_name
* @param mixed $sql_query
*/
function set_sql($sql_name,$sql_query){
    $DB=DBC::get();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM sys_queries WHERE name='$sql_name'",0);
    try {
        $DB->beginTransaction();
        if ($found==1) {
            DBC::execute("UPDATE sys_queries SET mysql=:sql_query WHERE name=:sql_name",array("sql_name"=>$sql_name,"sql_query"=>$sql_query));
        } else {
            DBC::execute("INSERT INTO sys_queries (name,mode,caption,title,mysql,window) VALUES (:sql_name,'none','-','-',:sql_query,'PRODUCTION')",array("sql_name"=>$sql_name,"sql_query"=>$sql_query));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);        
    }
} // EO set_sql
?>
