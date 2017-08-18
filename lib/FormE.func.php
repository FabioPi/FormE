<?php
/**
 * FormE.func v1.0.0 (part of FormEasy)
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

// ----------------------------------------------------------------------------------------------------------	
Function Encrypt($Text, $key=CRYPTO_KEY){
// ----------------------------------------------------------------------------------------------------------	

	$cryptText = ""; $i=0; $nLenT=0; $nLenK=0; $exText=""; $exKey=""; $Encr="";

	$exText=$Text;
    $exKey=$key;
	
	$nLenT = strlen($exText);
	$nLenK = strlen($exKey);
	
	while($nLenT>$nLenK) {
		$exKey = $exKey.$exKey;
		$nLenK = strlen($exKey); 
	}
	
	for($i=0; $i<strlen($exText); $i++ ){
		$Encr .= chr( BitXOR( ord(substr($exText,$i,1)) , ord(substr($exKey,$i,1)) ) + 0 );
	}	

	Return( bin2hex($Encr) );
	
} // End Function

// ----------------------------------------------------------------------------------------------------------	
Function Decrypt($Text, $key=CRYPTO_KEY) {
// ----------------------------------------------------------------------------------------------------------	
	$i=0; $nLenT=0; $nLenK=0; $exText=""; $exKey=""; $Decr="";

	$Text = hex2bin($Text);
	$exText=$Text;
    $exKey=$key;

	$nLenT = strlen($exText);
	$nLenK = strlen($exKey);
	
	while($nLenT>$nLenK) {
		$exKey = $exKey.$exKey;
		$nLenK = strlen($exKey); 
	}

	for($i=0; $i<strlen($exText); $i++ ){
		$Decr .= chr( BitXOR( ord(substr($exText,$i,1))-0, ord(substr($exKey,$i,1)) ) );
	}	

	Return($Decr);
}

// ----------------------------------------------------------------------------------------------------------	
Function BitXOR($a, $b){ Return ($a^$b); }
// ----------------------------------------------------------------------------------------------------------	

// -----------------------------------------------------------------------------------------------------------------------------------------		
function encode($data){ return( base64_encode($data) );  }
// -----------------------------------------------------------------------------------------------------------------------------------------		

// -----------------------------------------------------------------------------------------------------------------------------------------		
function decode($encData){ return( base64_decode($encData) ); }
// -----------------------------------------------------------------------------------------------------------------------------------------		

// ----------------------------------------------------------------------------------------------------------	
Function FPErrorLog($err){
//    Example :
//    FPErrorLog("this is the value of varName: $varName");
//    FPErrorLog("Values of arrayFruits : ".print_r($arrayFruits, true) );
// ----------------------------------------------------------------------------------------------------------	
	$logFile = "Log.txt";
	$logDate = date("Y-m-d H:i:s");
	
	$backtrace = debug_backtrace();
	$_file_=$backtrace[0]['file'];
	$_line_=$backtrace[0]['line'];
	
	// $errString = "$_file_ -> $logDate : $err \n";
	$errString = "$logDate : $_file_ ( $_line_ ) -> $err \n";

	// error_log ( print_r( $backtrace, true ), 3, $logFile);	
	error_log ( $errString, 3, $logFile);	
	
} // End Function

?>