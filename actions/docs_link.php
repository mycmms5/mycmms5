<?php
/**
* Linking Documents using PHPVC filesystem
* 
* @author  Werner Huysmans 
* @access  public
* @version $Id: docs_link.php,v 1.1 2013/12/25 08:50:00 werner Exp $4.0
* @filesource
* @package framework
* @filesource
*/
require("../includes/config_mycmms.inc.php");
$template=operation_template($_SERVER["SCRIPT_NAME"]);
require("setup.php");
$version=__FILE__." :V5.0 Build ".date ("F d Y H:i:s.", filemtime(__FILE__));
/** 
* Set the documents directory where we will search documents 
* Standard ../../common/documents_DEMO where demo is the DB name
*/
if (isset($_REQUEST['DOCTYPE'])) {  
    $_SESSION['DOCTYPE']=$_REQUEST['DOCTYPE']; 
}
require("config_docs.inc.php");
unset($_SESSION['PDO_ERROR']);  // Reset previous errors

/**
* Extract file type
* 
* @param mixed $filename
* @todo what is the use of file_exists
*/
function getFileType($filename) {
    $ext = substr(strrchr($filename, "."), 1);
    return file_exists('img/'.$ext.'.gif') ? $ext.'.gif' : 'txt.gif';
}
/**
* Return path string
* 
* @param mixed $path
*/
function translatePath($path) {
    if(substr($path, strlen($path)-2, 2) == '//')
        $path = substr($path, 0, strlen($path)-2);
    if(substr($path, strlen($path)-1, 1) == '/')
        $path = substr($path, 0, strlen($path)-1);
    
        if(substr($path, strlen($path)-2, 2) == '..')
        {
            $path = substr($path, 0, (strlen($path)-3));
            $path = substr($path, 0, strrpos($path, '/'));
        }
    return $path;
} // EO translatePath
/**
* Create a link in table dl and location of the file in dd</br>
* - Check existence in dd and dl
* - if empty INSERT
* 
* @param mixed $filepath
* @param mixed $docu_system
*/
function createLink($filepath,$docu_system) {
    global $doctype;
    $pathinfo=pathinfo($filepath);
    $sql_unique_dl="SELECT COUNT(*) FROM dl WHERE link='{$_SESSION['Ident_1']}' AND filename='{$pathinfo['basename']}'";
    $sql_insert_dl="INSERT INTO dl (ID,filename,type,link) VALUES (NULL,:filename,:doctype,:link)";
    $sql_unique_dd="SELECT COUNT(*) FROM dd WHERE filename='{$pathinfo['basename']}'";
    $sql_insert_dd="INSERT INTO dd (filename,filedescription,sha1,md5) VALUES (:filename,'No description found',:filepath,'0')";
    // Sanity check - do not add twice the same file...
    $exist_dl=DBC::fetchcolumn($sql_unique_dl,0);
    if ($exist_dl != 0) { 
        exit(); 
    } else {
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            DBC::execute($sql_insert_dl,array("filename"=>$pathinfo['basename'],"doctype"=>$doctype,"link"=>$_SESSION['Ident_1']));
            $exist_dd=DBC::fetchcolumn($sql_unique_dd,0);
            if ($exist_dd == 0) {
                DBC::execute($sql_insert_dd,array("filename"=>$pathinfo['basename'],"filepath"=>$pathinfo['dirname']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
    }
}
/**
* Show the directory-files
*/
if (is_file(PROJECT_DIR.translatePath($_REQUEST['file']))) {
    if(isset($_REQUEST['setlink'])) {
       createLink($_REQUEST['file'],DOCU);
    }
    $d=dir(PROJECT_DIR);
    $_REQUEST['file']=NULL;
} else { 
    $d=dir(PROJECT_DIR.translatePath($_REQUEST['file']));
}
for($i=0,$j=0,$files=array(),$directories=array(); $entry=$d->read(); ) {
    switch(strrchr($entry, ".")): 
        case '.': 
        case '..':                                                                
            break;
        case '':        
            $directories[$j++]=array(0 => $entry, 1 => 'folder.gif'); 
            break;
        default: {
            $files[$i++] = array(
                0 => $entry,
                1 => getFileType($entry),
                2 => DBC::fetchcolumn("SELECT DISTINCT filedescription FROM dd WHERE filename='".mysql_escape_string($entry)."'",0)
            );
            break;
        } // EO default
        endswitch;
} // EO for
$d->close();
/**
* Get the already linked files from dl-dd
*/
$DB=DBC::get();
$result=$DB->query("SELECT DISTINCT CONCAT(dd.sha1,'/',dl.filename) AS 'filepath',dl.filename,dd.filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE dl.type='{$doctype}' AND dl.link='{$_SESSION['Ident_1']}'");
$taskdocs=$result->fetchAll(PDO::FETCH_ASSOC);
$tpl = new smarty_mycmms();
$tpl->assign('stylesheet',STYLE_PATH."docs_upload.css");
$tpl->assign('version',$version);
$tpl->assign('template',$template);
$tpl->assign('index',$_SERVER['SCRIPT_NAME']);
$tpl->assign('object',$_SESSION['Ident_1']);
$tpl->assign('path', translatePath($_REQUEST['file']).'/');
$tpl->assign('files', $files);  # Files in open directory
$tpl->assign('directories', $directories);
$tpl->assign('rootdir',PROJECT_DIR);
$tpl->assign('taskdocs',$taskdocs);
$tpl->display_error($template);
?>
