<?php
/** 
* CSV functions
* 
* @author  Werner Huysmans 
*/
function EXCEL_real($value){
    return $value;
}
/*    If a value contains newlines. EXCEL converts these to new cells...
*     This function replaces the newlines with a /
*/
function EXCEL_string($value){
    return $value;
}

/*
* INPUT:    string     $SQL (SELECT stattement)
* INPUT:    string     $CSV (../export/$CSV.csv
*/
function make_csv($SQL, $CSV)
{    $DB=DBC::get();
    if ($myFile = fopen("../export/SQL_".$CSV.".csv","w+")) {
        $result = $DB->query($SQL);
        if ($result) {
            while($row = $DB->fetch_object($result))
            {    $fields = mysql_num_fields($result);
                // Header
                for ($i=0;$i<$fields;$i++)
                {    fwrite($myFile,mysql_field_name($result,$i).";");
                }
                fwrite($myFile,"\r\n");
                // Rows
                while($row = $DB->fetch_array($result)){
                for ($i=0;$i<$fields;$i++)
                {    if (mysql_field_type($result,$i)=="string") {
                        fwrite($myFile,$row[$i].";");
                    } else if (mysql_field_type($result,$i)=="int") {
                        fwrite($myFile,$row[$i].";");
                    } else if (mysql_field_type($result,$i)=="real") {
                        fwrite($myFile,$row[$i].";");
                    } else {
                        fwrite($myFile,$row[$i].";");
                    }
                } // for $fields
                fwrite($myFile,"\r\n");
                } // while
            }
            $DB->print_usermsg("Generated ".$CSV);
            fclose($myFile);
        }
        } // fopen
             else {
            $DB->print_usermsg("Couldn't open ".$CSV.".csv");
        }
}
/**
* SAP functions
* 
* @author  Werner Huysmans 
* @access  public
* @package libraries
* @subpackage SAP
* @filesource
*/
function SAP_trim($value,$length) {
    $trimmed_value=substr($value,0,$length);
    $trimmed_value=str_pad($trimmed_value,$length," ",STR_PAD_RIGHT);
    return $trimmed_value;
}
function SAP_date($value) {
// YYYY-MM-DD HH:MM:SS
    return substr($value,0,4).substr($value,5,2).substr($value,8,2);    
}
function SAP_datetime($value) {
    return substr($value,0,4).substr($value,5,2).substr($value,8,2).substr($value,11,2).substr($value,14,2);    
}
?> 

