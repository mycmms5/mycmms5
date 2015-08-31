<?php
/**
* This module will translate all paths in sys_navoptions to their absolute path
* Only to be used by System Administrator and after check of status.
*/
require("../includes/config_mycmms.inc.php");
$bUPDATE_translations=false;
$bUPDATE_mysql=false;
$bUPDATE_caption_title=true;

$DB=DBC::get();
//$result=$DB->query("SELECT * FROM sys_queries WHERE mysql LIKE 'SELECT%'",PDO::FETCH_ASSOC);
$result=$DB->query("SELECT * FROM sys_queries",PDO::FETCH_ASSOC);
foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $old_sql=$row['mysql'];
    $fields=substr($old_sql,0,strpos($old_sql,' FROM')); 
    $needle = "|.*AS '(.*)'|U"; //Regexp to match all aliases
    preg_match_all($needle, $fields, $col_names, PREG_PATTERN_ORDER ); //Store the aliases in the array '$col_names'
    $new_sql=$old_sql;
    $counter=0;
    foreach ($col_names[1] as $AliasColumnName) {
        if ($bUPDATE_translations) {
            DBC::execute("INSERT IGNORE INTO translations (original) VALUES ('{$AliasColumnName}')");
        }
        $BaseName=DBC::fetchcolumn("SELECT new FROM translations WHERE original='{$AliasColumnName}'",0);
        if (!$BaseName) {   $BaseName=$AliasColumnName; }
        $new_sql=str_replace($AliasColumnName,$BaseName,$new_sql,$NumReplaced);
        $counter=$counter+$NumReplaced;
    }
    
    if ($bUPDATE_mysql) {
        DBC::execute("UPDATE sys_queries SET mysql=:new_sql WHERE name=:name", array(("new_sql")=>$new_sql,"name"=>$row['name']));
        echo "<b>".$row['name']."</b> : <i>".$new_sql."</i><hr>";
    }
    if ($bUPDATE_caption_title) {
        $test=substr($row['caption'],0,3);
        $new_caption=$row['caption'];$new_title=$row['title'];
        if (substr($row['caption'],0,3)=="LC:") {   $new_caption=substr($row['caption'],3); }
        if (substr($row['title'],0,3)=="TT:")   {   $new_title=substr($row['caption'],3); }
        echo $name."--".$new_caption."--".$new_title;
        DBC::execute("UPDATE sys_queries SET caption=:new_caption,title=:new_title WHERE name=:name", array("new_caption"=>$new_caption,"new_title"=>$new_title,"name"=>$row['name']));
    }
}
?>
