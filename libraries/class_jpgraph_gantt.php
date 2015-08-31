<?php
/** 
* JPGraph GANTT: Generating GANTT charts
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2009
* @version: BETA
* @access  public
* @package library
* @subpackage classes
*/
/**
* CVS
* $Id: class_jpgraph_gantt.php,v 1.1 2013/04/18 06:28:38 werner Exp $
* $Source: /var/www/cvs/mycmms40_lib/mycmms40_lib/class_jpgraph_gantt.php,v $
* $Log: class_jpgraph_gantt.php,v $
* Revision 1.1  2013/04/18 06:28:38  werner
* Inserted CVS variables Id,Source and Log
*/
/**
* Class JPG_GANTT
* @package library
* @subpackage classes
*/
class JPG_GANTT {
    private $graph;
    public $gantt_title="GANTT title";
    public $scale=array("HDW"=>19,"DWM"=>7,"DHM"=>49);
    private $activity=array();
    public $color="blue";
/**
* Constructor
* include the JPGraph files
*/
    public function __construct() {
        require_once("jpgraph35pro/jpgraph.php"); 
        require_once("jpgraph35pro/jpgraph_gantt.php");     
    }
/**
* Init
* $HDW: Hours Days Weeks
*/
    public function init($HDW) {
//        $this->graph = new GanttGraph(0,0,"auto");
        $this->graph=new GanttGraph(3000,4000);
        $this->graph->hgrid->Show();
        $this->graph->title->Set($this->gantt_title);
        if ($HDW != "DHM") {
            $this->graph->ShowHeaders($this->scale[$HDW]);
            $this->graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY2);
            $this->graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAMEYEAR2);    
        } else {
            $this->graph->ShowHeaders(GANTT_HDAY |  GANTT_HHOUR |  GANTT_HMIN); 
            $this->graph->scale-> minute-> SetIntervall( 30); 
            $this->graph->scale-> minute-> SetBackgroundColor( 'lightyellow:1.5'); 
            $this->graph->scale-> minute-> SetFont( FF_FONT0); 
            $this->graph->scale-> minute-> SetStyle( MINUTESTYLE_MM); 
            $this->graph->scale-> minute->grid->SetColor ('lightgray');
        }
    }
/**
* Add a Work Order to the planning
* 
* $i: Incremental number
* $wo:  WO
* $start: Start date
* $end
* $ress: Resources
*/
    public function add_activity($i,$wo,$start,$end,$ress) {
        $this->activity[$i]=new GanttBar($i,$wo,$start,$end); 
        $this->activity[$i]->SetPattern(BAND_SOLID,$this->color);
        $this->activity[$i]->caption->Set($ress);
        $this->graph->Add($this->activity[$i]);
    }
/**
* Set a line on NOW on the graph     
*/
    public function set_now_marker() {
        $aNOW=getdate();
        $NOW=$aNOW["year"]."-".$aNOW["mon"]."-".$aNOW["mday"]." ".$aNOW["hours"].":".$aNOW["minutes"];
        $vline=new GanttVLine($NOW);
        $this->graph->Add($vline,"NU","darkred");
    }
    public function show_GANTT() {
        $this->graph->hgrid->SetRowFillColor("darkblue@0.9");
        $this->graph->Stroke();
    }
    public function setRange($start,$end) {
        $this->graph->SetDateRange($start,$end);
    }
}
?>

