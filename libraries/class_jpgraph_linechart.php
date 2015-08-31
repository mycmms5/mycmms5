<?php
/** JPGraph GANTT 
* Line Charts
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2008
* @version: BETA
* @access  public
* @package JPGRAPH
* @subpackage TRENDS
* @filesource
* CVS
* $Id: class_jpgraph_linechart.php,v 1.1 2013/04/18 06:28:38 werner Exp $
* $Source: /var/www/cvs/mycmms40_lib/mycmms40_lib/class_jpgraph_linechart.php,v $
* $Log: class_jpgraph_linechart.php,v $
* Revision 1.1  2013/04/18 06:28:38  werner
* Inserted CVS variables Id,Source and Log
*
*/
class JPG_LINECHART {
    private $graph;
    public $linechart_title="LineChart title";
    private $lineplot=array();
    private $colors=array("red","green","blue","orange","yellow");
    
    public function __construct() {
        require_once("jpgraph/jpgraph.php"); 
        require_once("jpgraph/jpgraph_line.php"); 
    }
    public function init($width,$heigth) {
        $this->graph=new Graph($width,$heigth,"auto");     
        $this->graph->title->Set($this->linechart_title);
        $this->graph->SetScale("textlin");      // Linear
    }
    public function set_X_scale($xLabels) {
        $this->graph->xaxis->SetTickLabels($xLabels);
    }
    public function add_Y_line($i,$yData,$legend) {
        $this->lineplot[$i]=new LinePlot($yData);
        $this->lineplot[$i]->SetFillColor($this->colors[$i]); 
        $this->lineplot[$i]->SetLegend($legend);
    }
    public function show_LINECHART() {
        $accPlot=new AccLinePlot($this->lineplot);
        $this->graph->Add($accPlot); 
        $this->graph->Stroke(); 
    }
}
?>
