<?php
	 
	include ("lib/FormE.class.php");
	include ("lib/FormE.func.php");
	
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
	
    <!-- Bootstrap CSS -->
	<link href="css/bootstrap4.min.css" rel="stylesheet">

	<!-- Datepicker CSS (remove if don't use DBDateXX) -->
	<link href="css/bootstrap-datepicker3.standalone.164.min.css"   rel="stylesheet">
	
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
	<!-- <script src="js/jquery.min.js"></script> -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	
    <!-- Reference to the Bing Maps SDK (remove if dont'use DBMapBing)-->
	<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?branch=experimental' async defer></script>

	<!-- Main Script (Don't Remove !!)-->
    <script src="js/FormE.js"></script>

  </head>
  <body>
    <h1>Main Form - Test (with BootStrap v4 alpha)</h1>
	 
	 
	 
	<?php
		//$myForm = new Forms("testLevel.xml");
		
		$myForm = new Forms("frmAnag5_horizontal.xml", "ANAId=1");
		// $myForm = new Forms("frmAnag5_block.xml", "ANAId=1");   // update records with ANAID=1
		// $myForm = new Forms("frmAnag5_block.xml");           // Insert NEW Record 
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
	

	
	// include always these rows below in your script (Questo ci deve sempre essere : valutare se metterlo dentro Form->Script)
    $( window ).on( "load", function() {
		$('div[onload]').trigger('onload');

		// Remove this code block if Don't use DBComboBoxCascade
		$( "._autocomplete_" ).each(function(){
			var compose = 	$(this).attr("compose");
			
			$(this).autocomplete({
				source: "_formAutoComplete.php?compose="+compose // name of controller followed by function
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
	function loadSearch(param){ alert (param); }
	
	function showSearch(t) { alert (t.id); }
	
	function funcAA(tab, desc){ alert("sto in on load"); }
	
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
		
	function validCitta(t){
		$("#_id_frmAnagrafica_DUGId").val("");  //Ok
		
		$( t ).offsetParent().addClass("has-warning");  // boxInput
		$( t ).addClass("form-control-warning");        // input field
	}
	
	function myFuncExit(objJson){
		// setting this in DBApply component (in xml file)
		alert ("sono in MyFunct error :"+objJson.Err.Status+"  - ID : "+objJson.ID.Value);
		return false;
	}
	
	</script> 
	<!-- Includere per Mappe BING (spostato sopra) -->
	<!-- <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?branch=experimental&callback=loadMapScenario' async defer></script> -->

	<!-- https://bootstrap-datepicker.readthedocs.io/en/latest/ -->
	<script src="js/bootstrap-datepicker.164.min.js"></script> 
	<script src="js/locales/bootstrap-datepicker.it.js" charset="UTF-8"></script> 
	<script src="js/locales/bootstrap-datepicker.en-GB.js" charset="UTF-8"></script> 
 
	<!--  http://igorescobar.github.io/jQuery-Mask-Plugin/  -->
	<script src="js/jquery.mask.min.js"></script>
	
	<!--  http://jasny.github.io/bootstrap/  -->
	<!-- <script src="js/fileinput.js"></script> -->
	<script src="js/jasny-bootstrap.min.js"></script>
	
    <!-- Include all compiled plugins (below), or include individual files as needed for bootstrap (respect the order) -->
	<script src="js/tether4.min.js"></script> 
    <script src="js/bootstrap4.min.js"></script>
 
  </body>
</html>

