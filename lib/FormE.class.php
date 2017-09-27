<?php
/**
 * FormE v1.0.0 (FormEasy)
 * Copyright 2016-2017 The FormE Author (Fabio Pintore)
 * @author: Fabio Pintore
 *
 * Created by Fabio Pintore. 
 *
 * The MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */ 
include("FormE.ini.php");
include("FormE.DB.class.php");


// ***************************************************************************************************************************************************************************************
class baseElements{
// ***************************************************************************************************************************************************************************************
	var $cHTML="", $XML="", $meForm="", $nameBase="", $data=""; 
	
	var $aAttrib=Array();	 
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function __construct($meForm, $xml) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->meForm = $meForm;
		$this->XML = $xml;
		$this->nameBase = "_".$this->meForm->nameForm."_".trim($this->XML);
	
		$this->ReadAttributesXML();
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	protected function addAttributes($attr, $value) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		if (substr($attr,0,2) == "x-"){
			// @($this->aAttrib["$attr"] .= " $value");
			switch ($attr) {
				case "x-col":
					// @($this->aAttrib["class"] .= "col-lg-$value ");
					@($this->aAttrib["class"] .= $this->meForm->layout."$value ");
					break;
				case "x-valid":
					@($this->aAttrib["onchange"] .= "javascript:$value(this)");
					break;
			}
		}else{
			switch ($attr) {
				case "style":
					@($this->aAttrib["$attr"] .= "$value;");  // si aggiungono attributi seguiti da  ;
					break;
				case "class":
					@($this->aAttrib["$attr"] .= "$value ");  // si aggiungono attributi seguiti da spazio  
					break;
				case "name":    // non si devono mettere i nomi (in caso creare x-name e gestirlo a livello di singolo componente)
				case "id":      // non si devono mettere gli id (in caso creare x-id   e gestirlo a livello di singolo componente)
					break;
				default :	
					@($this->aAttrib["$attr"] = "$value");   // si sostituisce l'attributo 
			}
		}
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	protected function removeAttributes($attr) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		unset($this->aAttrib[$attr]); 
	}	
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	protected function ReadAttributesXML(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		foreach ($this->XML->attributes() as $key => $value) {
			// $this->addAttributes($key, $value);
			$this->addAttributes(strtolower($key), $value);
		}
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	protected function AttributesToString(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$sAttr = "";
		foreach ($this->aAttrib as $key => $value) {
			$sAttr .= "$key='$value' "; 
		}
		return ($sAttr);		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function show(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$elemen = get_class($this);
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<$elemen $attr>$this->XML</$elemen>\n";
		
		return ($this->cHTML);
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	function __destruct(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->cHTML=null;
		$this->XML=null; 
        $this->aAttrib=null;
	}

	
} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class baseContainer extends baseElements {
// ***************************************************************************************************************************************************************************************

 	var $iParent=0, $aParent=Array();

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function show(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$elemen = get_class($this);
		$attr=$this->AttributesToString();
	
		$this->cHTML .= "<$elemen $attr>\n";
		$this->cHTML .= $this->TraverseXML($this->meForm, $this->XML)."\n";
		$this->cHTML .= "</$elemen>\n";
		
		return ($this->cHTML);
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function TraverseXML($meForm, $xml){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$cHTML=""; $objB;
		foreach ($xml->children() as $tree) {
	
			$nodeName = trim($tree->getName());   // bisogna fare trim xche $box["type"] ritorna una stringa sporca;
			
			try {
				$this->iParent +=1;
				$this->aParent[$this->iParent]["ComponentName"] = $nodeName;
				$objB = new $nodeName($meForm, $tree);
				$this->aParent[$this->iParent]["ComponentRef"] = $objB;
				$cHTML .= $objB->Show();
				$this->iParent -=1;
			}catch (Exception $e) {
				echo 'Error : ',  $e->getMessage(), "\n";
			}	
			
		}
			
		return ($cHTML);		
		
	}
	

	
} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class Forms extends baseContainer{
// ***************************************************************************************************************************************************************************************

	public $nameForm = "", $connDB="", $layout="";
	
	var $XML = "", $cHTML=""; 
	var $qTable, $tableName = "", $Table = "", $dataTable = Array(), $pkFields = Array(); 
	var $callFuncForm = "", $callFuncFormParam = "", $callFuncPost="";
	var $iCascade=-1, $aCascade=Array();
	
	public function __construct($xml, $qTable="false") {
		// qTable = False (new record)
		// qTable = "ANAID=1" (select record)
		if (file_exists($xml)) {
			$this->XML=simplexml_load_file($xml);
		}
		$this->qTable = $qTable;
		
		$this->ReadAttributesXML($xml);

	}
	 
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function Start(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		// $this->ReadAttributesXML($this->XML);
		// $this->table = "ilschedule";
		
		$this->tableName = trim($this->XML["x-table"]);
		$this->nameForm  = trim($this->XML["name"]);
		$this->layout    = $this->setLayout( trim($this->XML["x-layout"]) );
		
		// implementare x-layouts  con -> xs (phones), sm (tablets), md (desktops), and lg (larger desktops). 
		
 		$this->addAttributes("class", "container-fluid");
 		$this->addAttributes("style", "position:relative");
		// $this->addAttributes("class", "form-horizontal");
		$attr=$this->AttributesToString();

		
		// $this->OpenDB();
		$this->OpenTable();
		
		if (!empty($this->callFuncForm)){ $this->callbackData(); }
	
		$this->cHTML .= "\n<form id='$this->nameForm' method='post' action='' enctype='multipart/form-data'>\n";
		
		// $this->cHTML .= "<div class='container-fluid' $attr>\n\n";
		$this->cHTML .= "<div id='box_$this->nameForm' $attr>\n\n";
		
		$this->iParent =0;
		$this->aParent[$this->iParent]["ComponentName"] = "form";
		$this->aParent[$this->iParent]["ComponentRef"] = $this;
		
		$this->cHTML .= $this->TraverseXML($this, $this->XML)."\n";
		
		$this->cHTML .= $this->CheckCascade()."\n";
		
		$this->cHTML .= $this->AddExtraField()."\n";
		
		$this->cHTML .= "</div>\n";
		
		$this->cHTML .= "</form>\n";
	
		return ($this->cHTML);
		
	}	
	

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function OpenTable(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$dbC = new DB();
		$dbC->Param(HOST, NAMEDB, USER, PASSW);
		// $this->connDB = $dbC->Connect();
		
		$this->connDB = $dbC->Connect();
		
		$this->Table = new Table($this->connDB, $this->tableName);		
		$this->dataTable = @$this->Table->Select("SELECT * FROM ".$this->tableName." WHERE ".$this->qTable." LIMIT 1")[0];  // Estrae 1 Record [0]
		$this->pkFields = @$this->Table->chkPKKey();
		
	}

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function setLayout($lay){
	//  xs (phones), sm (tablets), md (desktops), and lg (larger desktops). 
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$layout = "";
		
		switch($lay) {
		
			case "phones": 
				$layout = "col-xs-";
				break; 

			case "tablets": 
				$layout = "col-sm-";
				break; 
			
			case "desktops": 
				$layout = "col-md-";
				break; 
				
			case "large": 
				$layout = "col-lg-";
				break; 
				
			default:	
				$layout = "col-md-";
		}
		
		return ($layout);
	}
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function registerCallbackFuncForm($func, $para=""){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->callFuncForm = $func;
		$this->callFuncFormParam = $para;
	}
	

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function registerCallbackFuncPost($func){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->callFuncPost = $func;
	}
	

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function callbackData(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->dataTable = call_user_func($this->callFuncForm, $this->dataTable, $this->callFuncFormParam);
	}

	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function addExtraField(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$cHTML=""; 
	
		if (!empty($this->callFuncPost)){
			$cHTML .= "<input type='hidden' name='callFuncPost' value='$this->callFuncPost' />\n";
		}
		
		foreach ($this->pkFields as $key => $val){
			$cHTML .= "<input type='hidden' id='_pk$val' name='_pk$val' value='".$this->getData($val)."' />\n";
		}	
		
		return ($cHTML);
	}
	

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function getData($field){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		return ( htmlentities(@$this->dataTable["$field"], ENT_QUOTES) );    // 30.05.2017
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function showVar(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$cHTML="";
		
		$cHTML .= "iParent: ".$this->iParent."\n";
		$cHTML .= "aParent_Component: ".$this->aParent[$this->iParent]["ComponentName"]."\n";

		return ($cHTML);
	}

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function getParent($lookForComponent){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		for ($i=$this->iParent; $i>=0; $i--){
			if ($this->aParent[$i]["ComponentName"] == trim($lookForComponent) ) {
				return ($this->aParent[$i]["ComponentRef"]);
			}
		}
		
		return (false);
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function AddCascade($nameGroupCascade, $paramOnChange, $actualValue, $callFunc){
	// -----------------------------------------------------------------------------------------------------------------------------------------		

		$this->iCascade +=1;
		$placeholder = "@".$this->iCascade."AABBCC@";
		
		$this->aCascade["$nameGroupCascade"][] = Array("0"=>$nameGroupCascade, "1"=>$placeholder, "2"=>$paramOnChange, "3"=>$actualValue, "4"=>$callFunc);
		// $this->aCascade["$nameGroupCascade"][$this->iCascade] = Array("0"=>$nameGroupCascade, "1"=>$placeholder, "2"=>$paramOnChange, "3"=>$actualValue, "4"=>$callFunc);
		
		$aRet=Array($this->iCascade, $placeholder );
		
		return ($aRet);
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function CheckCascade(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		

		foreach ($this->aCascade as $k => $v){
			
			for ($i=count($v)-1; $i>0; $i--){
				
				$this->cHTML = str_replace ( $v[$i-1][1] , 'onchange="javascript:_cbCascade(this,'.$v[$i][2].', '."'".$v[$i-1][4]."'".');"', $this->cHTML);	
				if ( !Empty( $v[$i][4] ) ){
					$this->cHTML = str_replace ( $v[$i][1] , 'onchange="javascript:'.$v[$i][4].'(this);"', $this->cHTML);	
				}else{
					$this->cHTML = str_replace ( $v[$i][1] , '', $this->cHTML);	
				}	
				
			}

		}
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function getCascade($nameGroup){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$i=0; $j=0; $retVal="";
		
		$lastEl = count($this->aCascade["$nameGroup"]) - 2; // Penultimo elemento inserito 
		$retVal=@$this->aCascade["$nameGroup"][$lastEl][3]; 		
		
		return ($retVal);
	}
	
} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class row extends baseContainer {
// ***************************************************************************************************************************************************************************************
	
	public function show(){
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "\n<div $attr> <!-- begin row --> \n\n";
		$this->cHTML .= $this->meForm->TraverseXML($this->meForm, $this->XML);
		$this->cHTML .= "</div>  <!-- end row --> \n";
		
		return ($this->cHTML);
	}
	
} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class boxInput extends  baseContainer {
// ***************************************************************************************************************************************************************************************
	
	public function show(){
		$this->addAttributes("class", "form-group");
		
		$attr=$this->AttributesToString();
	
		$this->cHTML .= "<div $attr>  <!-- begin boxInput --> \n";
		$this->cHTML .= $this->meForm->TraverseXML($this->meForm, $this->XML);
		$this->cHTML .= "</div>   <!-- End boxInput --> \n\n";
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class inline extends baseContainer {
// ***************************************************************************************************************************************************************************************

	public function show(){
		$this->addAttributes("class", "form-inline");
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<span $attr >\n";
		$this->cHTML .= $this->meForm->TraverseXML($this->meForm, $this->XML);
		$this->cHTML .= "</span>\n";
		
		return ($this->cHTML);
	}
	
} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class block extends baseContainer {
// ***************************************************************************************************************************************************************************************

	public function show(){
		$this->addAttributes("class", "form-inline");
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<div $attr >\n";
		$this->cHTML .= $this->meForm->TraverseXML($this->meForm, $this->XML);
		$this->cHTML .= "</div>\n";
		
		return ($this->cHTML);
	}
	
} // End Class   *************************************************************************************************************************************************************************


// Leaf 

// ***************************************************************************************************************************************************************************************
class label extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function show(){
		$this->addAttributes("class", "control-label");
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<label $attr >".$this->XML."</label>\n";
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class labelBlock extends baseContainer {
// ***************************************************************************************************************************************************************************************
	public function show(){
		$this->addAttributes("class", "control-label");

		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<label $attr >".$this->XML."\n";
		$this->cHTML .= $this->meForm->TraverseXML($this->meForm, $this->XML);
		$this->cHTML .= "</label>\n";
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class labelInLine extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function show(){
		$this->addAttributes("class", "control-label");

		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<label $attr >".$this->XML."</label>\n";
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class baseInput extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function __construct($meForm, $xml) {
		 parent::__construct($meForm, $xml);
		 
		$this->help();
		
		$this->column = !empty(trim($this->XML["x-col"])) ? "class='".$this->meForm->layout.trim($this->XML["x-col"])."'" : ""; 

		$tXML = trim($this->XML);
		$this->data = @($this->meForm->getData($tXML));
		
		if ( @$this->meForm->pkFields[999] == $tXML ) $this->addAttributes("pk", "auto");   //scrive l'attributo pk se auto_increment (solo 1 per table)
			
	}

	public function help(){
		
		$helpTitle="help"; $helpDescr=""; $inputHelp="";
		
		$helpTitle  = htmlspecialchars($this->XML->children()->help["x-title"], ENT_HTML5|ENT_QUOTES);
		$helpDescr  = htmlspecialchars($this->XML->children()->help, ENT_HTML5|ENT_QUOTES);

		if ( ! Empty($helpDescr)){

			// $inputHelp = "data-toggle='popover' data-placement='top' data-title='$helpTitle' data-content='$helpDescr' ";
			$this->addAttributes("data-toggle",    "popover");   //popover or tooltip ?
			$this->addAttributes("data-placement", "top");
			$this->addAttributes("data-title",     $helpTitle);
			$this->addAttributes("data-content",   $helpDescr);
		}
		
		return (true);
	}
	
	public function prepare(){
		
	}	

	public function show(){
	
		
		$this->cHTML .= "<div $this->column >\n";
		$this->prepare();
		$this->cHTML .= "</div>\n";
		
		
		return( $this->cHTML );
			
	}	

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBInput extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		$this->nameBase = "_inp1".$this->nameBase;
 		$this->addAttributes("class", "form-control");
		
		$attr=$this->AttributesToString();

		$this->cHTML .= "<input name='$this->nameBase' id='_id$this->nameBase' value='$this->data' $attr />\n";
		
		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBInput2 extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		$this->nameBase = "_inp2".$this->nameBase;
 		$this->addAttributes("class", "form-control");
		
		$image = !empty(trim($this->XML["x-image"])) ? "fa-".trim($this->XML["x-image"]) : "fa-star"; 

		$attr=$this->AttributesToString();

		$this->cHTML .= "<div class='input-group'>\n";
		$this->cHTML .= "<span class='input-group-addon'><i class='fa $image'></i></span>\n";
		$this->cHTML .= "<input type='text' name='$this->nameBase' id='_id$this->nameBase' value='$this->data' $attr />\n";
		$this->cHTML .= "</div>\n";

		return (true);
  	}
	
} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBInputFile extends baseInput {
// ***************************************************************************************************************************************************************************************
	// public function show(){
	public function prepare(){
		$nameBase1 = "_file".$this->nameBase;
		$nameBase2 = "_UpTo".$this->nameBase;
		$nameBase3 = "_OnDb".$this->nameBase;
		
		$UpTo = !empty(trim($this->XML["x-upload"])) ? trim($this->XML["x-upload"])."/" : UPLOAD_FILE."/"; 

		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<div class='fileinput fileinput-new input-group' data-provides='fileinput'>\n";
		$this->cHTML .= "  <div class='form-control' data-trigger='fileinput'><i class='fa fa-file fileinput-exists'></i> <span id='_id$nameBase3' class='fileinput-filename'>$this->data </span></div>\n";
		$this->cHTML .= "  <span class='input-group-addon btn btn-default btn-file'><span class='fileinput-new'>Select file</span><span class='fileinput-exists'>Change</span><input type='file' name='$nameBase1' id='_id$nameBase1' $attr /></span>\n";
		$this->cHTML .= "  <a href='#' class='input-group-addon btn btn-default fileinput-exists' data-dismiss='fileinput'>Remove</a>\n";
		$this->cHTML .= "  <input name='$nameBase2' id='_id$nameBase2' value='$UpTo' type='hidden' />\n";
		$this->cHTML .= "</div>\n";
		
		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBSearch extends baseInput {
// ***************************************************************************************************************************************************************************************
	// public function show(){
	public function prepare(){
		$paramExtra = "";
		$this->nameBase = "_srch".$this->nameBase;
		
		$this->removeAttributes("onchange");

 		$this->addAttributes("class", "form-control");
 		$this->addAttributes("class", "_autocomplete_");
		
		$xValid  =  !empty( $this->XML["x-valid"] ) ? ' onclick="javascript:'.trim($this->XML["x-valid"]).'(this);return false;"' : '' ;
		
		$searchTable  = trim($this->XML["x-SearchTable"]);
		$searchField  = trim($this->XML["x-SearchField"]);
		$searchReturn = trim($this->XML["x-SearchReturn"]);
		$paramExtra = htmlspecialchars($this->XML->children()->DBSearchReturn->asXML(), ENT_HTML5|ENT_QUOTES);

		$paramExtra = $searchTable."|".$searchField."|".$searchReturn."|".$paramExtra;
		$encParamExtra = encode($paramExtra);
		
	
		$attr=$this->AttributesToString();

		$this->cHTML .= "<div class='input-group'>\n";
		$this->cHTML .= " <input type='text' name='$this->nameBase' id='_id$this->nameBase' compose='$encParamExtra' value='$this->data' $attr />\n";
		$this->cHTML .= "  <span class='input-group-addon'><i> \n";
		$this->cHTML .= "    <button id='_id_butt_$this->nameBase' class='fa fa-search' $xValid></button></i>\n";
		$this->cHTML .= "  </span>\n";
		$this->cHTML .= "</div>\n";

		return (true);
  	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBTextArea extends baseInput {
// ***************************************************************************************************************************************************************************************
	// public function show(){
	public function prepare(){
		$this->nameBase = "_txar".$this->nameBase;
 		$this->addAttributes("class", "form-control");
		
		$this->addAttributes("wrap", "hard");

		$attr=$this->AttributesToString();

		$this->cHTML .= "<textarea name='$this->nameBase' id='_id$this->nameBase' $attr />$this->data</textarea>\n";
		
		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBDate extends baseInput {
// ***************************************************************************************************************************************************************************************
	// public function show(){
	public function prepare(){
		
		
		$this->settings();
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<div class='input-group date'>\n";
		$this->cHTML .= "<input name='$this->nameBase' id='_id$this->nameBase' type='text' value='$this->data' $attr />\n";
        $this->cHTML .= "<div class='input-group-addon'>\n";
        $this->cHTML .= "<span class='fa fa-calendar'></span>\n";
		$this->cHTML .= "</div></div>\n";
		
		return (true);
	}
	
} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBDateIT extends DBDate {
// ***************************************************************************************************************************************************************************************
	public function settings(){
		// parent::prepare();

		$this->nameBase = "_dtIT".$this->nameBase;
 		$this->addAttributes("class", "form-control");
		
		$this->data = substr($this->data,8,2)."-".substr($this->data,5,2)."-".substr($this->data,0,4);
		
		$this->addAttributes("class", "datepicker");
		
		$this->addAttributes("data-mask",                 "00-00-0000");
		$this->addAttributes("data-provide",              "datepicker");
		$this->addAttributes("data-date-language",        "it");
		$this->addAttributes("data-date-format",          "dd-mm-yyyy");
		$this->addAttributes("data-date-today-highlight", "true");

		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBDateEN extends DBDate {
// ***************************************************************************************************************************************************************************************
	public function settings(){
		
		$this->nameBase = "_dtEN".$this->nameBase;
 		$this->addAttributes("class", "form-control");

		$this->data = substr($this->data,5,2)."/".substr($this->data,8,2)."/".substr($this->data,0,4);
		
		$this->addAttributes("class", "datepicker");

		$this->addAttributes("data-mask",                 "00/00/0000");
		$this->addAttributes("data-provide",              "datepicker");
		$this->addAttributes("data-date-language",        "en");
		$this->addAttributes("data-date-format",          "mm/dd/yyyy");
		$this->addAttributes("data-date-today-highlight", "true");
		
		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBOption extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function show(){
		
		$dataM = Array("");
		
		$dataM = explode ( ";", $this->meForm->getParent("DBComboBox")->data );
		
		$tbRef   = $this->XML["x-tbRef"];
		$tbKey   = $this->XML["x-tbKey"];
		$tbDescr = $this->XML["x-tbDescr"];
		$tbOrder = !empty ($this->XML["x-tbOrder"]) ? $this->XML["x-tbOrder"] : $this->XML["x-tbDescr"] ;
		
		$objTableRef = new Table( $this->meForm->connDB, $tbRef);
		
		$q="SELECT $tbKey, $tbDescr FROM $tbRef ORDER BY $tbOrder";
		$rows = $objTableRef->Select($q);
		
		$this->cHTML .= "<option value=''></option>";
		
		foreach ($rows as $val){
			$valOpt=$val["$tbKey"];
			$this->cHTML .= "<option value='$valOpt'";
			
			if ( in_array($valOpt, $dataM ) ) $this->cHTML .= " selected='selected'";
			$this->cHTML .= ">".$val["$tbDescr"];
			$this->cHTML .= "</option>\n";
		}
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBComboBox extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		
		$this->nameBase = "_cbox".$this->nameBase;
 		$this->addAttributes("class", "form-control");
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<select name='$this->nameBase[]' id='_id$this->nameBase' $attr >\n";
		
		$this->cHTML .= $this->meForm->TraverseXML($this->meForm, $this->XML);
		
		$this->cHTML .= "</select>\n";
		
		return (true);
	}
	
	
} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBComboBoxCascade extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		
		$this->nameBase = "_cbox".$this->nameBase;
 		$this->addAttributes("class", "form-control");
		$this->removeAttributes("onchange");
		
		
		$this->data = explode ( ";", $this->data );
		
		$nameGroup = trim($this->XML["x-cbCascade"]);
		$callFunc =  !empty( $this->XML["x-valid"] ) ? trim( $this->XML["x-valid"]) : "" ;
		
		$tbRef       = $this->XML->children()->DBOption["x-tbRef"];
		$tbKey       = $this->XML->children()->DBOption["x-tbKey"];
		$tbDescr     = $this->XML->children()->DBOption["x-tbDescr"];
		$tbOrder     = !empty ($this->XML->children()->DBOption["x-tbOrder"]) ? $this->XML->children()->DBOption["x-tbOrder"] : $this->XML->children()->DBOption["x-tbDescr"] ;
 		$tbParentKey = $this->XML->children()->DBOption["x-tbParentKey"];
		
		// $parOnChange = "'_id$this->nameBase','tbRef=$tbRef|tbKey=$tbKey|tbDescr=$tbDescr|tbParentKey=$tbParentKey|tbOrder=$tbOrder'";
		$encPar = Encrypt("tbRef=$tbRef|tbKey=$tbKey|tbDescr=$tbDescr|tbParentKey=$tbParentKey|tbOrder=$tbOrder", CRYPTO_KEY );
		$parOnChange = "'_id$this->nameBase','$encPar'";
		
		$aParamOnChange = $this->meForm->AddCascade($nameGroup, $parOnChange, $this->data[0], $callFunc);
		
		$attr=$this->AttributesToString();
		
		$nameCascade = $nameGroup."-".str_pad($aParamOnChange[0], 2, "0", STR_PAD_LEFT);   // AA-01    //Original with minus sign
		
		$this->cHTML .= "<select name='$this->nameBase[]' id='_id$this->nameBase' cascade='$nameCascade'  $aParamOnChange[1] $attr >\n";
		
		$objTableRef = new Table( $this->meForm->connDB, $tbRef);
		
		$parentVal = $this->meForm->getCascade($nameGroup);
		
	
		if ( $aParamOnChange[0]>0){
			$q="SELECT $tbKey, $tbDescr FROM $tbRef WHERE $tbParentKey='$parentVal' ORDER BY $tbOrder";
		}else{
			$q="SELECT $tbKey, $tbDescr FROM $tbRef ORDER BY $tbOrder";
		}

		$this->cHTML .= "<option value=''></option>";  // Aggiungo riga vuota 
		
		$rows = $objTableRef->Select($q);
		foreach ($rows as $val){
			$valOpt=$val["$tbKey"];
			$this->cHTML .= "<option value='$valOpt'";
			if ( in_array($valOpt, $this->data ) ) $this->cHTML .= " selected='selected'";
			$this->cHTML .= ">".$val["$tbDescr"];
			$this->cHTML .= "</option>\n";
		}
		
		$this->cHTML .= "</select>\n";
		
		return (true);
	}
	
} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBRadio extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		$this->nameBase = "_rdio".$this->nameBase;
		$this->addAttributes("class", "radio");
		
		
		$attr=$this->AttributesToString();
		// for vertical
		/*
		foreach ($this->XML->children() as $val ){
			$valOpt = $val["value"];
			$this->cHTML .= "<input type='radio' name='$this->nameBase' id='_id$this->nameBase' value='$valOpt' $attr";
			if ( $this->data == $valOpt ) $this->cHTML .= " checked='checked'";
			$this->cHTML .= "/> $val <br/>\n";
		}
		*/
		
		// for inline NO <br> final
		foreach ($this->XML->children() as $val ){
			$valOpt = $val["value"];
			$this->cHTML .= "<input type='radio' name='$this->nameBase' id='_id$this->nameBase' value='$valOpt' $attr";
			if ( $this->data == $valOpt ) $this->cHTML .= " checked='checked'";
			$this->cHTML .= "/> $val &nbsp;&nbsp;\n";
		}
		
		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBCheck extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function Show(){
		$_On = 1; $_Off = 0;
		
		$tXML = trim($this->XML);
		$this->data = @($this->meForm->getData($tXML));
		$this->nameBase = "_chek".$this->nameBase;
		// $this->addAttributes("class", "form-control");
		$this->addAttributes("class", "checkbox");
		
		$descr  = trim($this->XML["x-descr"]); 
		$states = !empty(trim($this->XML["x-states"])) ? trim($this->XML["x-states"]) : "1|0"; 
		
		// $states = "1|0";
		list ($_On, $_Off) = explode ( "|", $states);
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<input type='checkbox' onchange=\"javascript:_setChekBox(this, '$_On', '$_Off')\" name='chk_$this->nameBase' id='_id$this->nameBase' $attr";
		if ( $this->data == $_On ) $this->cHTML .= " checked='checked'";
		$this->cHTML .= "/> $descr &nbsp;&nbsp;\n";
		$this->cHTML .= "<input type='hidden' name='$this->nameBase' id='ck_id$this->nameBase' value='$this->data' />";
		// $this->cHTML .= "<br/>\n";

		return ($this->cHTML);
	}
	
} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBIcon extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		$this->nameBase = "_icon".$this->nameBase;
		$this->addAttributes("class", "form-control");
		// $this->addAttributes("class", "img-responsive");
		$descr  = @trim($this->XML["x-descr"]); 
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .=  "      <div id='_id_main$this->nameBase' ondrop='_drop_icon(event)' ondragover='_allowDrop_icon(event)' >\n";
		$this->cHTML .=  "        <img src='$this->data' id='_id_prew$this->nameBase' $attr />\n";
		$this->cHTML .=  "        <div style='text-align:center'>$descr</div>"; 
		$this->cHTML .=  "      </div>\n";
		$this->cHTML .=  "      <input type='text' name='$this->nameBase' id='_id_text$this->nameBase' onchange='javascript:_changeIcon(this)' style='display:none;' value='$this->data' />\n";
		

		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************

// ***************************************************************************************************************************************************************************************
class DBMapBing extends baseInput {
// ***************************************************************************************************************************************************************************************
	public function prepare(){
		$this->nameBase = "_mapb".$this->nameBase;
		$this->addAttributes("class", "form-control");
	
		$this->data  = (!empty($this->data)) ? $this->data : '45.0000;45.0000';
		
		list ($lat, $lon) = explode ( ";", $this->data);
		
		$attr=$this->AttributesToString();
	
		$this->cHTML .=  "<div id='_id_main$this->nameBase' $attr onload=\"javascript:FPMap.Create(this, $lat,$lon)\"></div>\n";
		$this->cHTML .=  "<input type='text' name='$this->nameBase' id='_id$this->nameBase' style='display:none;' value='$this->data' />\n";
   
		return (true);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class DBApply extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function show(){
		
		$nameForm=$this->meForm->nameForm;
		$tableForm=$this->meForm->tableName;
		
		$callBackFunc = !empty( trim($this->XML["x-callback"]) ) ? trim($this->XML["x-callback"]): ""; 
		
		$this->addAttributes("class", "btn btn-primary");
		
		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<button $attr onclick=\"saveRecord('$nameForm','$tableForm','$callBackFunc');return false\"> <i class='fa fa-save'></i>&nbsp;&nbsp;&nbsp;$this->XML</button>\n";
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************


// ***************************************************************************************************************************************************************************************
class reset extends baseElements {
// ***************************************************************************************************************************************************************************************
	public function show(){
		$this->nameBase = "_rset".$this->nameBase;

		$this->addAttributes("class", "btn btn-secondary");

		$attr=$this->AttributesToString();
		
		$this->cHTML .= "<button $attr onclick=\"_reset(this); return false\"> <i class='fa fa-undo'></i>&nbsp;&nbsp;&nbsp;$this->XML</button>\n";
		
		return ($this->cHTML);
	}

} // End Class   *************************************************************************************************************************************************************************

?>	
