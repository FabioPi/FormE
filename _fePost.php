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
include("lib/FormE.DB.class.php");
include ("lib/FormE.func.php");
include ("lib/userPostFunc.php");

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
class PostData {
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// public $resJSON = Array();
	// public $aFldVal = Array(); 
	// public $tabNet = "";
	
	private $resJSON = Array(), $aFldVal = Array(), $tabNet = "";

	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function __construct() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->resJSON['Err']['Status'] = false;
		$this->resJSON['Err']['DESCR'] = "<br/>";
	
	}
	
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function connect() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$dbC = new DB();
		$dbC->Param(HOST, NAMEDB, USER, PASSW);
		
		$this->tabNet  = new Table($dbC->Connect(), $_POST["_TABLE_"]);	
	}
	
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function creaField() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$frmName = $_POST["_FORM_"];	
		$lfrmName = strlen($frmName);
		
		foreach ($_POST as $key => $val) {
			
			if ( substr($key,6,$lfrmName ) == $frmName ){   //_inp1_frmAnagrafica_ANANome (0=_; 1=f; 2=r; ....) 1 a len
			
				$keyField = substr($key,$lfrmName+2+5);    // ANANome
				$aFldApp["Name"]  = $keyField      ;       // $aFldVal["ANANome"]["Name"]="ANANome"
				$aFldApp["Prototype"] = substr($key,1,4);  // $aFldVal["ANANome"]["Prototype"]="inp1" 
				$valueField = $_POST["$key"];
				
				switch ( $aFldApp["Prototype"] ) {
					
					case "dtIT":
						// value dd-mm-aaaa -> transfrom -> aaaa-mm-dd
						$aFldApp["Value"]=( !Empty($valueField) ) ? substr($valueField,6,4)."-".substr($valueField,3,2)."-".substr($valueField,0,2) : NULL ;
						break;

					case "dtEN":
						// value mm/dd/aaaa -> transfrom -> aaaa-mm-dd
						$aFldApp["Value"]=( !Empty($valueField) ) ? substr($valueField,6,4)."-".substr($valueField,0,2)."-".substr($valueField,3,2) : NULL ;
						break;
						
					case "cbox":
						// ComboBox 
						$ret="";
						foreach ($valueField as $vals){
							$ret .= $vals.";";	
						}
						$aFldApp["Value"] = substr($ret,0,-1);
						break;
						
					case "UpTo":
						// File
						$sApp = "_file_".$frmName."_".$keyField;
						$sOnDb = "_id_OnDb_".$frmName."_".$keyField;
						
						$aFldApp["Value"] = ( !empty($_FILES["$sApp"]["name"])) ? $valueField.$_FILES["$sApp"]["name"] : ( !empty($_POST["$sOnDb"]) ? $_POST["$sOnDb"] : "" );
						$aFldApp["keyFile"] = $sApp;  // This index "KeyFile" is only for UpTo			
						break;
						
					default:
						$aFldApp["Value"] = $valueField; // TEST 26.5.2017
				}
				
				// $this->aFldVal[]=$aFldApp;
				
				// $aFldVal["ANANome"]["Name"]="ANANome"
				// $aFldVal["ANANome"]["Prototype"]="inp1" 
				$this->aFldVal[$keyField]=$aFldApp;

			}
		}		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	private function postAction(){
	// -----------------------------------------------------------------------------------------------------------------------------------------	
		$aRetFunc = Array();
		
		if ( !Empty($_POST["callFuncPost"]) ){ 
			$aRetFunc = call_user_func($_POST["callFuncPost"], $this->aFldVal, $this->resJSON);
			
			$this->aFldVal = $aRetFunc["Field"];
			$this->resJSON = $aRetFunc["jSON"];

		}	
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function writeData(){
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$aPKKey=Array(); $lAct = "INS"; $whereUPD=""; $key=""; $val=""; $ID=""; $i=0;
		
		$this->connect();
		$this->creaField();
		$this->postAction();

		// 11/3/2017 $aPKKey = $tabNet->chkPKKey();
		$aPKKey = $this->tabNet->chkPKKey();
		
		if ( $this->resJSON['Err']['Status'] == false ) {
			
			foreach ( $aPKKey as $val ) {
				$whereUPD .= "$val = '".$_POST["_pk$val"]."' AND " ;
				if ( ( isset($_POST["_pk$val"]) ) and ( $_POST["_pk$val"] > "" ) )  $lAct = "UPD";	
			}
			$whereUPD = substr($whereUPD,0,-4);
			
			if ($lAct=="UPD"){
				$ID = $this->tabNet->Update2($this->aFldVal, $whereUPD);	
			}else{
				$ID=$this->tabNet->Insert2($this->aFldVal);
			}	
			
			$this->resJSON['ID']['Value'] = $ID;
			
			$i=0;
			foreach ($aPKKey as $key=>$val){
				
				//$resJSON['ID']['Key'][1] = "_Id";
				// $this->resJSON['ID']['Key']["_pk$val"] = "$val";
				$this->resJSON['Key'][$i]["name"]  = "$val";
				// $this->resJSON['Key'][$i]["value"] = $aFldVal["$val"]["Value"];
				if ( !isset($this->aFldVal["$val"]["Value"]) ){
					// $this->resJSON['Key'][$i]["value"] = $_POST["_fk$val"];
					$this->resJSON['Key'][$i]["value"] = $_POST["_pk$val"];
				}else{
					$this->resJSON['Key'][$i]["value"] = $this->aFldVal["$val"]["Value"];
				}
				if ($ID>0 && $key==999) $this->resJSON['Key'][$i]["value"] = $ID;
				
				$i++;
			}	
			
				
			foreach ($this->aFldVal as $k=>$v){
				if ( ($v["Prototype"] == "UpTo") and ( !empty( $v["Value"]) ) ) {   // if there is an error NOT upload so don't loose time !!
					$fldName = $v["keyFile"];
					move_uploaded_file($_FILES["$fldName"]["tmp_name"], $v["Value"]);
				}
			}
		
		}
		
		return ($this->resJSON);
	} //End Function
	
 } // End Class   -------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$myPostData = new PostData();


if ( $_POST["_ACT_"] == "_Save_" )	$resJSON = $myPostData->writeData();
	// if ( $_POST["ACT"] == "Del" )	delNetworks();

header("Content-type: text/plain");
echo json_encode($resJSON);

?>