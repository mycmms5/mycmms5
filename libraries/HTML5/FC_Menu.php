<?PHP
class Menu {
/**
* Array of categories
* @var    array
* @access private
*/
var $_categories = array();
/**
* Array of permissible link for this person
* @var    array
* @access public
*/
var $permissible = array();
/**
* Adds a category box to the menu
* @param   string    $name
* @access  public
*/
function addCategory($name) {
    $this->_categories[$name] = array();
    return $name;
}
/**
* Adds a link to the menu
* @param   string    $name
* @access  public
*/
function addLink($link, $cat = "") {
    if(empty($cat)) { //if no category was passed to the function use the last category 
	    end($this->_categories);
        $cat = key($this->_categories);
	}
	if(!isset($this->_categories["$cat"])) { // If the category doesn't exist yet
        $this->addCategory($cat);
	}
	if($link_html = url($link)) {
        array_push($this->_categories["$cat"], $link_html);
	}
}
function toHtml() {   
    $html = "";
    foreach($this->_categories as $cat=>$cat_contents) {   
        if(!empty($cat_contents)) { //if there are links in this category...
	        $html .= "\n <div class=\"box\">\n<h5>$cat</h5>\n<div class=\"body\">\n<div class=\"content odd\">";
            $html .= implode("\n", $cat_contents);
	        $html .= "</div></div></div>";
	    }
	}
    return $html;}
}
?>