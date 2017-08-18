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

$aParams=Array(); $decData=""; $aParams=""; $tbRef=""; $tbKey=""; $tbDescr=""; $tbParent=""; $tbOrder=""; $tVal="";    

// $aParams = explode( "|", $_GET["tmpData"]);

$decData = Decrypt($_GET["tmpData"]);
$aParams = explode( "|", $decData);

$tbRef    = explode( "=", $aParams[0])[1];
$tbKey    = explode( "=", $aParams[1])[1];
$tbDescr  = explode( "=", $aParams[2])[1];
$tbParent = explode( "=", $aParams[3])[1];
$tbOrder  = explode( "=", $aParams[4])[1];
$tVal     = $_GET["tVal"];


$dbC = new DB();
$dbC->Param(HOST, NAMEDB, USER, PASSW);
			
$tabNet  = new Table($dbC->Connect());
$resJSON = $tabNet->Select("SELECT $tbKey AS _code_, $tbDescr AS _descr_ FROM $tbRef WHERE $tbParent='$tVal' ORDER BY $tbOrder"); 	


header("Content-type: text/plain");
echo json_encode($resJSON,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
// echo json_encode($resJSON);
?>