<?php

// ----------------------------------------------------------------------------------------------------------	
Function AnagModPost($aFieldData, $resJSON){
// ----------------------------------------------------------------------------------------------------------
	$aRetVal = Array();	
	
	if ( ip2long($aFieldData["IPStart"]["Value"]) > ip2long($aFieldData["IPEnd"]["Value"]) ) {
			$resJSON['Err']['Status'] = true;
			$resJSON['Err']['DESCR'] .= "Range IP non valido !<br/>";
			$resJSON['Err']['FIELD'][] = "_inp1_frmAnagrafica_IPStart";	
			$resJSON['Err']['FIELD'][] = "_inp1_frmAnagrafica_IPEnd";	
	}else{

		$aFieldData["ANAIp"]=Array("Name"=>"ANAIp", "Value"=>$aFieldData["IPStart"]["Value"]."-".$aFieldData["IPEnd"]["Value"], "Prototype"=>"");	
		
		unset($aFieldData["IPStart"]); 
		unset($aFieldData["IPEnd"]); 
	}
	
	$aRetVal = Array("Field"=>$aFieldData, "jSON"=>$resJSON);
	
	return ($aRetVal);

} 


?>