<style type="text/css">
body {
/*    font-family: arial, helvetica, geneva, sans-serif; 
*/
    font-family: Verdana, Geneva, sans-serif;
    font-size: 10px;    }
table {
    font-size: 10px;
    border-spacing: 1px;
    border-style: solid;
    line-height: normal;
}
td {
    color: darkgrey;
    padding: 1px;
    font-size: 14px; }
td.OCCUPIED {
    color: black;
    background-color: cyan; }    
td.FREE {
    color: white;
    background-color: darkgreen; }
</style>
<?php
/**
* Action: get a list of occupied HAMA 
* Reviewed @ 18/04/2015
* @package tabwindow
* @subpackage music
* @var mixed
*/
$stylesheet="CSS_SMARTY";
$deep2=true;
require("../../includes/config_mycmms.inc.php");
$DB=DBC::get();
$HAMA=array("HAMANR"=>3,
            "0"=>array(1,390),
            "1"=>array(401,390),
            "2"=>array(801,100),
            "3"=>array(901,200)
            );
$HAMAFULL=array();
/** HAMA1 
* 
*/
for ($hama=0; $hama<=$HAMA["HAMANR"]; $hama++) {
    echo "<table width='100%'>";
    $HAMAFULL[$hama]=false;
    for ($i=$HAMA[$hama][0];$i<=$HAMA[$hama][0]+$HAMA[$hama][1]-1;$i++) {
        $RecordingID=DBC::fetchColumn("SELECT RecordingID FROM records2 WHERE HAMA=$i",0);
        if (empty($RecordingID)) {
            echo "<tr><td width='15%' class='FREE'><I>HAMA <B>".$i."</B></td><td colspan=10>is Free</I></td></tr>";        
            $HAMAFULL[$hama]=true;
        } else {
            $result=$DB->query("SELECT * FROM records WHERE RecordingID='{$RecordingID}'");
            $record=$result->fetch(PDO::FETCH_ASSOC);
            # echo "<tr><td>HAMA <b>$i</b></td><td class='OCCUPIED'>".$record['Artist']." / ".$record['Title']."</td></tr>";
        }
    }
    if (!$HAMAFULL[$hama]) {
        echo "<tr><th colspan='3'>HAMA_BOX_".($hama+1)." is completely filled</th></tr>";
    } else {
        echo "<tr><th colspan='3'>HAMA_BOX_".($hama+1)." has the following free places</th></tr>";
    }
}
echo DBC::fetchcolumn("SELECT MAX(Classification) AS 'HAMA' FROM records",0);
?>
