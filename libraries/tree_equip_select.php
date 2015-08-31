<?php 
/**
* @package    Framework
* @subpackage DBTreeView
* @author     Rodolphe Cardon de Lichtbuer <rodolphe@wol.be>
* @copyright  2007 Rodolphe Cardon de Lichtbuer
* @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
* CVS
* $Id: tree_equip_select.php,v 1.3 2013/11/04 07:54:59 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/libraries/tree_equip_select.php,v $
* $Log: tree_equip_select.php,v $
* Revision 1.3  2013/11/04 07:54:59  werner
* Using Library V4.1
*
* Revision 1.2  2013/04/17 06:04:44  werner
* Inserted CVS variables Id,Source and Log
*
*/
require("../includes/config_mycmms.inc.php");
define("TREEVIEW_LIB_PATH","dbtreeview");
require_once(TREEVIEW_LIB_PATH."/dbtreeview.php");
define("DB_HOST",SERVER_ADDRESS);
define("DB_USER","root");
define("DB_PASSWORD","sdeygh");
define("DB_DATABASE","mycmms_vpk");
define("DB_TABLE","equip"); 

class myHandler implements RequestHandler{
/**
* Connects to the DB 
* DO NOT CHANGE THIS CODE
*     
* @param ChildrenRequest $req
* @return ChildrenResponse
*/
    public function set_table($tree_table) {
        $this->$tree_table = $_REQUEST['tree_table'];        
    }
    public function set_return_form ($return_form) {
        $this->$return_form = $_REQUEST['return_form'];
    }
    public function handleChildrenRequest(ChildrenRequest $req){
		$attributes = $req->getAttributes();	
		if(!isset($attributes['code'])){
			die("error: attribute code not given");
		}
		$parentCode = $attributes['code'];
		$depth = 1;
		if(isset($attributes['depth'])){
			$depth = $attributes['depth'];
		}
		if($depth<1){
			die("depth error : must be > 0");
		}
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Unable to connect to database.");
		mysql_select_db(DB_DATABASE) or die("Could not select database");
		if(!mysql_query("SET CHARACTER SET utf8")){
			throw new Exception('Could not set character set UTF-8.');
		}
		$nodes = $this->getChildrenDepth($depth, 1, $parentCode);
		$response = DBTreeView::createChildrenResponse($nodes);
		return $response;
		mysql_close($link);
	}
/**
* Returns an array of children with subchildren
* DO NOT CHANGE THIS CODE
* 	
* @param mixed $depth
* @param mixed $currentDepth
* @param mixed $parentCode
* @return TreeNode[]
*/
	private function getChildrenDepth($depth, $currentDepth, $parentCode){
        $nodes =  $this->getChildren($parentCode);
		if($currentDepth < $depth){
			foreach($nodes as $node){
				$childAttrs =$node->getAttributes();
				$childCode = $childAttrs["code"];
				if($childCode==NULL){
					die("child code is null");
				}
				$children =  $this->getChildrenDepth($depth, $currentDepth+1, $childCode);
				if($children==NULL){
					//die("null");
				}
				$node->setChildren($children);
				$node->setIsOpenByDefault(true);
			}
		}
		return $nodes;
	}
/**
* Returns the children (array)
* CUSTOMIZE
* Table must contain minimum: id, parent and description
* 
* @param mixed $parentCode
* @return TreeNode[]
*/
	private function getChildren($parentCode){
        # DebugBreak();
		$query = sprintf("SELECT * FROM equip WHERE parent='%s'", mysql_escape_string($parentCode));
		$result = mysql_query($query) or die("Query failed");
		$nodes=array();
		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["postid"];
            $eqnum = $line["EQNUM"];
            $description = $line["DESCRIPTION"];
			$text = "<b>$eqnum</b> : ".$line["DESCRIPTION"];
			$node = DBTreeView::createTreeNode(
				$text, array("code"=>$code));
			    $node->setURL(sprintf("javascript:
                    opener.document.treeform.EQNUM.value='$eqnum';
                    opener.document.treeform.DESCRIPTION.value='$description';
                    window.close(); "));
		        //has children
			    $query2 = sprintf("SELECT * FROM equip WHERE parent='%s' LIMIT 1", mysql_escape_string($code));
                $result2 = mysql_query($query2) or die("Query failed");
			    if(!mysql_fetch_assoc($result2)){
				    //no children
				    $node->setHasChildren(false);
				    $node->setClosedIcon("doc.gif");
			    }
			    $nodes[] = $node;
		} // EO while
		// Lib?ration des r?sultats 
		mysql_free_result($result);
		return $nodes;
	}
} //class TestListener
try{
	DBTreeView::processRequest(new MyHandler());
}catch(Exception $e){
	echo("Error:". $e->getMessage());
}
?>
<html>
<head>
<script src="dbtreeview/treeview.js" type="text/javascript"></script>
<link href="dbtreeview/dbtreeview_screen.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="dbtreeview/dbtreeview.css" rel="stylesheet" type="text/css" media="screen"/>
</head>
<body>
<?php
$rootAttributes = array("code"=>"0", "depth"=>"3");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,TREEVIEW_LIB_PATH,$treeID);
$tv->setRootHTMLText("Equipment Tree");
$tv->setRootIcon("star.gif");
$tv->printTreeViewScript();
?>
</body>
</html>
