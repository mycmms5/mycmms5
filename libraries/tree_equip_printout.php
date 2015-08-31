<?php 
/**
* @package    Framework
* @subpackage DBTreeView
* @author     Rodolphe Cardon de Lichtbuer <rodolphe@wol.be>
* @copyright  2007 Rodolphe Cardon de Lichtbuer
* @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
* CVS
* $Id: tree_equip_printout.php,v 1.2 2013/04/17 06:04:44 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/libraries/tree_equip_printout.php,v $
* $Log: tree_equip_printout.php,v $
* Revision 1.2  2013/04/17 06:04:44  werner
* Inserted CVS variables Id,Source and Log
*
*/
require("../includes/config_mycmms.inc.php");
define("TREEVIEW_LIB_PATH",CMMS_LIB."/dbtreeview");
require_once(TREEVIEW_LIB_PATH."/dbtreeview.php");
require_once("tree_credentials.php"); 

class myHandler implements RequestHandler{
/**
* Connects to the DB 
* DO NOT CHANGE THIS CODE
*     
* @param ChildrenRequest $req
* @return ChildrenResponse
*/
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
		$query = sprintf("SELECT * FROM equip WHERE parent='%s'", mysql_escape_string($parentCode));
		$result = mysql_query($query) or die("Query failed");
		$nodes=array();
        $options="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,titlebar=no,copyhistory=yes,width=700,height=800";
		while ($line = mysql_fetch_assoc($result)) {
			$code = $line["postid"];
            $eqnum = $line["EQNUM"];
			$text = "<b>$eqnum</b> : ".$line["DESCRIPTION"];
			$node = DBTreeView::createTreeNode(
				$text, array("code"=>$code));
			    $node->setURL(sprintf("javascript:window.open(\"../objects/object_print.php?id1=$eqnum\",\"printout_object\",\"$options\");"));
		        //has children
			    $query2 = sprintf("SELECT * FROM ".DB_TABLE." WHERE parent='%s' LIMIT 1", mysql_escape_string($code));
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
	echo("Erreur:". $e->getMessage());
}
?>
<html>
<head>
<script src="http://localhost/common/pear/PEAR/myCMMS40_lib/dbtreeview/treeview.js" type="text/javascript"></script>
<link href="http://localhost/common/pear/PEAR/myCMMS40_styles/dbtreeview_screen.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="http://localhost/common/pear/PEAR/myCMMS40_styles/dbtreeview.css" rel="stylesheet" type="text/css" media="screen"/>
</head>
<body>
<h1>Equipment Tree</h1>
<?php
$rootAttributes = array("code"=>"0", "depth"=>"2");
$treeID = "treev1";
$tv = DBTreeView::createTreeView(
		$rootAttributes,
		"http://localhost/common/pear/PEAR/".TREEVIEW_LIB_PATH, 
		$treeID);
$tv->setRootHTMLText("Equipment Tree");
$tv->setRootIcon("star.gif");
$tv->printTreeViewScript();
?>
</body>
</html>
