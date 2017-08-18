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

function clearFields($s){  return( str_replace ( "@" , "", $s) ); }

    FPErrorLog("Sono in _formAutoComplete");


	$queryString = $_GET["term"];
    $composeOrig = $_GET["compose"];
    $compose = decode($composeOrig);
	
    FPErrorLog("queryString :$queryString");
	
	list( $searchTable, $searchField, $searchReturn, $xml) = explode ( "|", $compose );

	$dbC = new DB();
	$dbC->Param(HOST, NAMEDB, USER, PASSW);
			
	$tabRic  = new Table($dbC->Connect(),"stato");	

	$resQry = $tabRic->Select("SELECT * FROM $searchTable WHERE $searchField like '%".$queryString."%' ORDER BY $searchField LIMIT 10");
	
	$xml = str_replace ( "&lt;DBSearchReturn&gt;"  , "", $xml);	
	$xml = str_replace ( "&lt;/DBSearchReturn&gt;" , "", $xml);	
	
	preg_match_all("/@(\w)+@/", $xml, $fieldsMark);
	$fieldsDB = array_map("clearFields", $fieldsMark[0]);

	foreach ($resQry as $row){
		$resRow = $xml;
		foreach($fieldsDB as $field){
			$resRow = str_replace ( "@$field@" , $row[$field], $resRow);	
		}
		
		$new_row['label']=html_entity_decode($resRow, ENT_HTML5|ENT_QUOTES);
		$new_row['value']=$row[$searchReturn];
		
		$row_set[] = $new_row; //build an array
	}	
	
    FPErrorLog("return of row_set : ".print_r($row_set, true) );

	
	echo json_encode($row_set); //format the array into json data
?>	
