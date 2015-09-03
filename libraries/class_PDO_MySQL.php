<?php
/** 
* class DBC extends PDO 
* connection to MySQL
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2012-05
* @access  public
* @package library
* @subpackage classes
* @filesource
* CVS
* $Id: class_PDO_MySQL.php,v 1.4 2013/12/25 08:40:08 werner Exp $
* $Source: /var/www/cvs/mycmms40_lib/mycmms40_lib/class_PDO_MySQL.php,v $
* $Log: class_PDO_MySQL.php,v $
* Revision 5.0  2015/07/26 12:30:00  werner
* Added function getDatabaseName to retrieve the name of the DB
* Revision 1.4  2013/12/25 08:40:08  werner
* Removed $driverOpts from connection string
* Revision 1.3  2013/06/10 09:52:19  werner
* PDO::fetchColumn is now a transaction
* Revision 1.2  2013/06/08 11:45:07  werner
* PDO transaction
*/
class DBC extends PDO {
    private static $dbh;
    public static $host;
    public static $database;
    public static $dsn;
    public static $uid;
    public static $pwd;
    public static $driverOpts=array(
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
        PDO::ATTR_EMULATE_PREPARES => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    private static $counter;
    public $sql;
    public $array;

    // No cloning or instantiating allowed
    public function __construct() {
        $this->get();
    }
/** get
* The get function checks whether a connection is available, if not it creates one.
* 
* @returns PDO PDO-database handle                  
*/
    public static function get() {
        // Connect if not already connected
        if (is_null(self::$dbh)) {
            self::$counter++;
            self::setDatabase();
            try {
                self::$dbh=new PDO(self::$dsn,self::$uid,self::$pwd);   #,self::$driverOpts);
                // self::$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
                // self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // self::$dbh->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''))
            } catch (PDOException $e) {
                echo 'Connection failed: '.$e->getMessage();
                echo "<br>Host:Database:UID:PWD ".self::$dsn.":".self::$database.":".self::$uid.":".self::$pwd;
            }
        }
        // Return the connection
        return self::$dbh;
    } // End get
/**
* Execute INSERT, UPDATE, ... query
*     
* @param mixed $sql     SELECT statement with placeholders
* @param mixed $array   array with data for placeholders
* @return bool
*/
    public static function execute($sql,$array) {
        $st=self::$dbh->prepare($sql);
        return $st->execute($array);
    } // End execute
/**
* Execute SELECT statement for 1 element
*     
* @param mixed $sql
* @param mixed $column
* @return string
*/
    public function fetchcolumn($sql,$column) {
        try {
            $res=self::$dbh->query($sql);
            $value=$res->fetchColumn($column);
            return $value;    
        } catch (Exception $e) {
            PDO_LOG($e);
        }
    }
/**
* Execute SELECT statement for more elements
*     
* @param mixed $sql
* @return mixed
*/
    public function fetchcolumns($sql) {
        $res=self::$dbh->query($sql);
        $values=$res->fetch(PDO::FETCH_NUM);
        return $values;
    }
/** numrows
* Returns the number of records
*     
* @param mixed $sql
* @return string
*/
    public function numrows($sql) {
        try {
            $st=self::$dbh->query($sql);
            $all=$st->fetchAll(PDO::FETCH_COLUMN,1);
        } catch (Exception $e) {
            PDO_log($e);
        }
        return count($all);
    } // End numrows
/** PDOError
* Puts a bow with a database warning on the screen.
*     
* @param mixed $error
*/
    public function setDatabase() {
        $ini_array = parse_ini_file("databases.inc.php", true);
        self::$host=$ini_array[CMMS_DB]["host"];
        self::$database=$ini_array[CMMS_DB]["DB"];
        self::$uid=$ini_array[CMMS_DB]["uid"];
        self::$pwd=$ini_array[CMMS_DB]["pwd"];
        self::$dsn="mysql:host=".self::$host.";dbname=".self::$database; 
    }
    public function getDatabase() {
        return self::$host."::".self::$database." (reconnects: ".self::$counter.")";
    }
    public function getDatabaseName() {
        return self::$database;
    }
}
?>
