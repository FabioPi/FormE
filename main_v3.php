<?php
	 
	include ("lib/FormE.class.php");
	include ("lib/FormE.func.php");
	
	// User PHP Function
	function AnagModForm($dataTable){
		
		@list($ipStart, $ipEnd) = explode ( "-", $dataTable["ANAIp"]);
		
		$dataTable["IPStart"] = $ipStart;	
		$dataTable["IPEnd"]   = $ipEnd;	
		
		unset($dataTable["ANAIp"]); 

		
		return ($dataTable);
	}

?>	
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
	<link href="css/bootstrap3.min.css" rel="stylesheet">
	
	<!-- Datepicker CSS (remove if don't use DBDateXX) -->
    <link href="css/datepicker3.css"   rel="stylesheet">

	<!-- File CSS (remove if don't use DBInputFile) -->
	<link href="css/fileinput.css"     rel="stylesheet">
	<!-- <link href="css/jasny-bootstrap.min.css"     rel="stylesheet"> -->

    <!-- Font CSS x Bootstrap -->
	<link href="css/font-awesome.css"   rel="stylesheet">
	
    <!-- JQuery UI CSS -->
	<link href="css/jquery-ui.min.css"  rel="stylesheet">
	
	<style>
		.errorInput{color:#ffffff; background-color:#ff0000;}
	</style>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="js/jquery-ui.min.js"></script>
	
    <!-- Reference to the Bing Maps SDK (remove if dont'use DBMapBing)-->
	<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?branch=experimental' async defer></script>

	<!-- Main Script (Don't Remove !!)-->
	<script src="js/FormE.js"></script>

  </head>
  <body>
    <h1>Main Form - Test (with BootStrap v3)</h1>
	 
	 
	 
	<?php
		//$myForm = new Forms("testLevel.xml");
		
		// $myForm = new Forms("frmAnag5_horizontal.xml", "ANAId=1");
		$seek = !isset($_GET["ANAID"]) ? "false" : "ANAId=".$_GET["ANAID"];
		$myForm = new Forms($_GET["xml"], $seek );
		
		// $myForm = new Forms("frmAnag5_block.xml", "ANAId=1");   // update records with ANAID=1
		// $myForm = new Forms("frmAnag5_block.xml");              // Insert NEW Record 
		$myForm->registerCallbackFuncForm("AnagModForm","");    // callableFunction, optionalParameters  -> at composite of form
		$myForm->registerCallbackFuncPost("AnagModPost");       // callableFunction  -> at post fase . include the function in formPost.php
		
		$cHTML = $myForm->Start();
		
		echo $cHTML;
	?>
	
	
	<script> 
	
	// Remove this code block if Don't use DBInputFile	
	$(function() {
		// We can attach the `fileselect` event to all file inputs on the page
		$(document).on('change', ':file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		});
		
		// We can watch for our custom `fileselect` event like this
		$(document).ready( function() {
				$(':file').on('fileselect', function(event, numFiles, label) {
		
					var input = $(this).parents('.input-group').find(':text'),
						log = numFiles > 1 ? numFiles + ' files selected' : label;
		
					if( input.length ) {
						input.val(log);
					} else {
						if( log ) alert(log);
					}
		
				});
		});
	});
	
	
    $( window ).on( "load", function() {
 
		// Include this row if you use DBMapBing 
		$('div[onload]').trigger('onload');

		// Remove this code block if Don't use DBSearch
		$( "._autocomplete_" ).each(function(){
			var compose = 	$(this).attr("compose");
			
			$(this).autocomplete({
				source: "_feAutoComplete.php?compose="+compose // name of controller followed by function
			}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append(item.label)
					.appendTo( ul );
			};
		});
    });
	 
    
	 
	// 
	// USER Javascript Function 
	// 

	function showSearch(t) { alert ( "you have select: "+$("#_id_srch_frmAnagrafica_ANASearch").val() ); }

	function showMap(t){
		var q="";
		switch(t.id) {
		
			case "_id_cbox_frmAnagrafica_COId": 
				q += $("#_id_cbox_frmAnagrafica_COId option:selected").text();
				break; 
				
			case "_id_cbox_frmAnagrafica_STId": 
				q += $("#_id_cbox_frmAnagrafica_STId option:selected").text();
				q += ", "+$("#_id_cbox_frmAnagrafica_COId option:selected").text();
				break; 
				
			case "_id_cbox_frmAnagrafica_CTId": 
			
				q += $("#_id_cbox_frmAnagrafica_CTId option:selected").text();
				q += ", "+$("#_id_cbox_frmAnagrafica_STId option:selected").text();
				// q += ","+$("#_id_cbox_frmMappa_COId option:selected").text();
				break; 
				
			case "_id_inp1_frmAnagrafica_ANAVia": 
			
				q += $("#_id_cbox_frmAnagrafica_DUGId option:selected").text();
				q += " "+$("#_id_inp1_frmAnagrafica_ANAVia").val();
				q += ", "+$("#_id_cbox_frmAnagrafica_CTId option:selected").text();
				// q += ","+$("#_id_cbox_frmMappa_STId option:selected").text();
				// q += ","+$("#_id_cbox_frmMappa_COId option:selected").text();
				break; 
				
			case "_id_inp1_frmAnagrafica_ANACoordText":
				q = $("#_id_inp1_frmAnagrafica_ANACoordText").val();
				break; 
				
			default: 
				break;
		}
		
		FPMap.Search(q, "_id_mapb_frmAnagrafica_ANAMap" );
		
	}
		
		
	function checkEmail(t) {

		// var email = document.getElementById('txtEmail');
		var email = t;
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
		if (!filter.test(email.value)) {
			
			email.focus;
			_setErrorInput(t, "on");
			
			return false;
			
		}else{
			_setErrorInput(t, "off");
		}	
		
	}	
	
	function validCitta(t){
		$("#_id_frmAnagrafica_DUGId").val("");  
		
		$( t ).offsetParent().addClass("has-warning");  // boxInput
		$( t ).addClass("form-control-warning");        // input field
	}
	
	function myFuncExit(objJson){
		alert ("FOR TEST ONLY !! MyFunct error :"+objJson.Err.Status+"  - ID : "+objJson.ID.Value);
		return false;
	}
	
	</script> 
	<!-- Includere per Mappe BING (spostato sopra) -->
	<!-- <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?branch=experimental&callback=loadMapScenario' async defer></script> -->

	<!-- https://bootstrap-datepicker.readthedocs.io/en/latest/ -->
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/locales/bootstrap-datepicker.it.js" charset="UTF-8"></script> 
	<script src="js/locales/bootstrap-datepicker.en-GB.js" charset="UTF-8"></script> 
 
	<!--  http://igorescobar.github.io/jQuery-Mask-Plugin/  -->
	<!-- <script src="js/jquery.mask.min.js"></script> -->
	<script src="js/jquery.mask.js"></script>  <!-- Modified version by FP -->
	
	<!--  http://jasny.github.io/bootstrap/  -->
	<script src="js/jasny-bootstrap.min.js"></script>
	
    <!-- Include all compiled plugins (below), or include individual files as needed for bootstrap v3 (respect the order) -->
   <script src="js/bootstrap3.min.js"></script>
 
  </body>
</html>

