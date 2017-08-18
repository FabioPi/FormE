<?php
/**
 * FormE.DB v1.0.0 (part of FormEasy)
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

//***************************************************************************************************************************************************************************************************
class DB {
//***************************************************************************************************************************************************************************************************

	// member declaration
	private $dbHost="", $dbName="",  $dbUser="", $dbPassw="", $dbConn="", $selDB=0;
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function Param($Host, $nameDb, $User, $Passw) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->dbHost  = $Host;
		$this->dbName  = $nameDb;
		$this->dbUser  = $User;
		$this->dbPassw = $Passw;
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function Connect() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$this->dbConn = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassw, $this->dbName) or die("Connessione non riuscita: " . mysqli_connect_errno() );
		mysqli_set_charset($this->dbConn, 'utf8'); 
		
		return ($this->dbConn);
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function Close() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		mysql_close($this->dbConn);
	}	
	
} // End Class DB
//***************************************************************************************************************************************************************************************************

//***************************************************************************************************************************************************************************************************
class Table {
//***************************************************************************************************************************************************************************************************

	private $DBConn=0, $NameTable="", $errDB=False, $Err=False;

   	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function Table($dbConn, $table="") {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$this->DBConn = $dbConn;
		$this->NameTable = $table;
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function Execute($qryExec) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		
		$oQry = mysqli_query($this->DBConn, $qryExec) or die("Query non valida: " . mysqli_error($this->DBConn));
		
		return ($oQry);
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    private function doUpdateStrings2($aFld) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	    // crea 1 stringa x UPDATE
		$ret=Array(""); 
		$renderVal="";
		
		foreach($aFld as $aFldV ){
			
			if ( !is_null($aFldV["Value"]) ) {
				$ret[0] .= "".$aFldV["Name"]."='".mysqli_real_escape_string($this->DBConn, $aFldV["Value"])."',";
				// $ret[0] .= "".$aFldV["Name"]."='".$aFldV["Value"]."',";
			}else{
				$ret[0] .= "".$aFldV["Name"]."=NULL,";
			}	
		}
		
		$ret[0] = substr($ret[0],0,-1);
			
		return( $ret );
		
	}

	// -----------------------------------------------------------------------------------------------------------------------------------------		
    private function doInsertStrings2($aFld) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	    // crea 2 stringe x INSERT
		// $ret=Array("","","",""); 
		$ret=Array("","",""); 
		$renderVal="";
		$aKeys = $this->chkPKKey();
		
		array_unshift($aKeys, ""); //inserisce alla posizione ZERO dell'Array un valore nullo per fare funzionare "array_search($aFields[$i], $aKeys) == 0"
		
		foreach($aFld as $aFldV ){
			
			$ret[0] .= "".$aFldV["Name"].",";
			
			if ( !is_null($aFldV["Value"]) ) {
				$ret[1] .= "'".mysqli_real_escape_string($this->DBConn, $aFldV["Value"])."',"; // 15.1.2017
			}else{
				$ret[1] .= "NULL,"; // 15.1.2017
			}	

			if ( array_search($aFldV["Name"], $aKeys) == 0) $ret[2] .= $aFldV["Name"]."=".$renderVal.","; 
		}
		
		$ret[0] = substr($ret[0],0,-1);
		$ret[1] = substr($ret[1],0,-1);
		$ret[2] = substr($ret[2],0,-1);
		
		return( $ret );
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function Insert2($aFldVal) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$retS = Array(); $InsStr=""; $oQry="";
		
		$retS = $this->doInsertStrings2($aFldVal);
		$InsStr = "INSERT INTO $this->NameTable ($retS[0]) VALUES ($retS[1])";
		
		$oQry = $this->Execute($InsStr); 
		$retID=mysqli_insert_id($this->DBConn );
		
		return ($retID);
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function Update2($aFldVal, $w) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$retS = Array(); $UpdStr=""; $oQry="";
		
		$retS = $this->doUpdateStrings2($aFldVal);
		
		$UpdStr = "UPDATE $this->NameTable SET $retS[0] WHERE $w";
		
		fpErrorLog("UpdStr : $UpdStr");
		
		$oQry = $this->Execute($UpdStr); 
		$retID=mysqli_insert_id($this->DBConn );
		
		return ($retID);
		
	}

	// -----------------------------------------------------------------------------------------------------------------------------------------		
    public function InsertORUpdate2($aFldVal) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		// INSERT INTO table (id, name, age) VALUES(1, "Mario", 19) ON DUPLICATE KEY UPDATE name=VALUES(name), age=VALUES(age)
		$retS = Array(); $InsStr=""; $oQry=""; 
		
		$retS = $this->doInsertStrings2($aFldVal);
		$InsStr = "INSERT INTO $this->NameTable ($retS[0]) VALUES ($retS[1]) ON DUPLICATE KEY UPDATE $retS[2]";
		
		$oQry = $this->Execute($InsStr); 
		$retID=mysqli_insert_id($this->DBConn);

		return ($retID);
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function Select($qryExec) {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$oQry=""; $i=0; $row=Array(); $retExec=Array();
		
		// $oQry = mysqli_query($this->DBConn, $qryExec) or die("Query non valida: " . mysqli_error($this->DBConn));
		$oQry = $this->Execute($qryExec);
		while ($row = mysqli_fetch_array($oQry)) {
		// while ($row = mysqli_fetch_array($oQry, MYSQLI_ASSOC)) {
			$retExec[$i]=$row;
			$i++;
		}

		mysqli_free_result($oQry);
		
		return ($retExec);
		
	}
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function DelRecord($id) {}
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function chkPKKey() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$resField=Array(); $aFields=Array(); $i=0;
		
		$aFields = $this->Select("SHOW COLUMNS FROM ".$this->NameTable );
		for ($i=0;$i<count($aFields);$i++){
			if( $aFields[$i]["Key"] == "PRI") {
				if ($aFields[$i]["Extra"] == "auto_increment") {
					$resField[999] = $aFields[$i]["Field"];
				}else{
					$resField[] = $aFields[$i]["Field"];
				}
			}	
		}
		
		return ($resField);  
		
	}

	
	// -----------------------------------------------------------------------------------------------------------------------------------------		
	public function Close() {
	// -----------------------------------------------------------------------------------------------------------------------------------------		
		$this->NameTable = "";
	}


} // End Class Table
//***************************************************************************************************************************************************************************************************

?>