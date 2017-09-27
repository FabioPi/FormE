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
 
 	function AlertForm(frmName, typeMess, textMess){

		if(typeof(typeMess) === "undefined") var typeMess = "";
		var messClass="";
		var messTitle="";
		var timeMess=5000;
		
		switch(typeMess) {
			case 'ERR':
				messClass = "alert-danger";
				messTitle = " Error !! ";
				timeMess=15000;
			break;
			case 'OK':
				messClass = "alert-success";
				messTitle = " Success !! ";
			break;
			default:
				messClass = "alert-info";
				messTitle = " Info ";
		}
		
		$( "#__AlertForm" ).remove();
		
		// var card='<div id="__AlertForm" style="display:none; z-index:1000; position: absolute; width: 390px; top:40%; left:40%;" class="alert '+messClass+'" role="alert">';
		var card='<div id="__AlertForm" style="display:none; z-index:1000; position:fixed; width:390px; top:40%; left:40%;" class="alert '+messClass+'" role="alert">';
		card += '<strong>'+messTitle+'</strong>';
		card += ' '+textMess;
		card += '<div>';
		
		$(card).appendTo("#box_"+frmName);
		// $(card).appendTo('body');
		
		options = { to: { width: 280, height: 185 } };
		$( "#__AlertForm" ).show( "fade", options, 500, callBackAlert );
	}
	
	function callBackAlert() {
		setTimeout(function() {
				$( "#__AlertForm:visible" ).removeAttr( "style" ).fadeOut();
			},
		5000 );
    }
	
	function _setErrorInput(tInput, state) {
		
		if (state=="on"){
			$( tInput ).offsetParent().addClass("has-warning");  // boxInput
			$( tInput ).addClass("form-control-warning");        // input field
			$( tInput ).popover("show");
		}else{
			$( tInput ).offsetParent().removeClass("has-warning");  // boxInput
			$( tInput ).removeClass("form-control-warning");        // input field
			$( tInput ).popover("hide");        // input field
		}
		
	}
	
	function _setChekBox(t, _On, _Off) {
		var inpCheckID = "#ck"+t.id;
		if(t.checked){
			$(inpCheckID).attr("value", _On); 
		} else {
			$(inpCheckID).attr("value", _Off);
		}
	}
	
	
	function _changeIcon(t){
		var inpIcon = "#ck"+t.id;
	}
	
	function fillZero(num, zero){
		var strNum = "" + num;
		return (zero.substring(0, zero.length - strNum.length) + strNum);
	}
	
	function _cbCascade(t, targetId, Data, callFunc){
		// this, _id_cbox_frmAnagrafica_CTId, 'tbRef=Citta|tbKey=CTId|tbDescr=CTDescr|tbParentKey=STId'
		if (targetId > ""){
			
			var groupID = $( t ).attr("cascade"); 
			var groupName = groupID.substring(0,groupID.length - 2);
			var groupNum  = parseInt( groupID.substring(groupID.length-2, groupID.length))+1;
			var valZero = "";
			var pad = "00";
			
			for (var i=groupNum; i<=99; i++){
				// valZero = groupName+i;
				valZero = groupName+fillZero(i, "00");
				// $( "select[cascade|='"+valZero+"']" ).val("");
				idCascade = $( "select[cascade|='"+valZero+"']" );
				$(idCascade).html("");
				// $(idCascade).val(""); // Not Work , clear at video but not in Database
				// $(idCascade).val([]); // Not Work , clear at video but not in Database
				$(idCascade).append('<option value="" selected="selected"></option>');   // so WORK !! 
			}
			
			
			$.ajax({
				type: "GET",
				url: "_feCascade.php?tmpData="+Data+"&tVal="+t.value,
				success: function(data)
				{
					// var objJSON = JSON.parse(data);
					var objJSON = jQuery.parseJSON( data );   // 1.6.2017
					
					$("#"+targetId).html("");
					$("#"+targetId).append('<option value=""></option>');  
					for (i=0; i<objJSON.length; i++){
						$("#"+targetId).append('<option value="' + objJSON[i]["_code_"]+ '">' + objJSON[i]["_descr_"] + '</option>');
					}	
				}
			});
			
			if (callFunc > ""){
				var fn = window[callFunc];
				if (typeof fn === "function") fn.call(null, t);
			}
		}  
	}

	function _reset(t){
		var idForm = t.form.id;
		var elements = t.form.elements; 
		var fName="", fProto="", aField="" ;
		
		t.form.reset();
		
		for(i=0; i<elements.length; i++) {
			
			fName = elements[i].name;    // _inp1_frmAnagrafica_ANAId	
			fProto = fName.substring(1,5);         // inp1 
			switch(fProto) {
			
				case "chek": 
					// document.getElementById("_id"+fName).onchange();
					$("#_id"+fName).trigger('onchange');
					break; 
		
				case "icon": 
					$("#_id_prew"+fName).attr("src", $("#_id_text"+fName).val());
					break; 
					
				default: 
					break;
			}
		}
		
	}
	
	function testRequired(tForm) {
		
		var fName="", lRequired=false;
		var oForm = eval(tForm);
    
		var elements = oForm.elements; 
		
		for(i=0; i<elements.length; i++) {
			fName = elements[i].name;    // _inp1_frmAnagrafica_ANAId	
			fProto = fName.substring(1,5); 
			
			if (fProto == "cbox") fName = fName.substring(0,fName.length - 2);   // _cbox_frmAnagrafica_COId[] togliere le []
		
			if ( (elements[i].required) && !(elements[i].value>"") ){
				$( "#_id"+fName ).offsetParent().addClass("has-warning");    // boxInput
				$( "#_id"+fName ).addClass("form-control-warning");          // Field
				$( "#_id"+fName ).popover("show");

				AlertForm(tForm, "ERR", "Fields required ");
				
				lRequired=true;
			}
			
		}
		
		return (lRequired);
	}

	// 	dataType: "json",
	function isJson(item) {
		item = typeof item !== "string" ? JSON.stringify(item) : item;

		try {
			item = JSON.parse(item);
		} catch (e) {
			return false;
		}

		if (typeof item === "object" && item !== null) {
			return true;
		}

		return false;
	}
	
	// Class FPMap ----------------------------------------------------------------------------------------------------------------------------------------
	function FPMap(){
		this.map = "";
		this.pin = "";
	};
	
	FPMap.Create = function(t, lat, lon){
		// alert ("id :"+t.id+" lat, lon : "+lat+","+lon);
	
		// var centerAt = new Microsoft.Maps.Location(41.89015,12.4924);
		var centerAt = new Microsoft.Maps.Location(lat,lon);
	 
		this.map = new Microsoft.Maps.Map('#'+t.id, {
			credentials: '------ YOUR BING KEY HERE !!!!! ------',    // PLEASE INSERT YOUR CREDENTIALS !!!!!
			center: centerAt,
			mapTypeId: Microsoft.Maps.MapTypeId.road,
			zoom: 12
		});

		// var pin = new Microsoft.Maps.Pushpin(center, {icon: 'BluePushpin.png', width: 50, height: 50, draggable: true});
		this.pin = new Microsoft.Maps.Pushpin(centerAt, {draggable: true});
		this.map.entities.push(this.pin);
	
		// Abilita il Drag&Drop del PIN 
		var Events = Microsoft.Maps.Events;
		Events.addHandler(this.pin, 'dragend', MapDragEnd );
	}
	
	FPMap.Search = function(query, idFieldMap){
		var tMap = this.map;  // fare cosi altrimenti non funziona 
		var tPin = this.pin;  // fare cosi altrimenti non funziona 
	
		Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
			var searchManager = new Microsoft.Maps.Search.SearchManager(tMap);
			var requestOptions = {
					bounds: tMap.getBounds(),
					where: query,
					callback: function (answer, userData) {
						tMap.setView({ bounds: answer.results[0].bestView });
						// var pins = [	new Microsoft.Maps.Pushpin(answer.results[0].location) ];	 
						tPin.setLocation(answer.results[0].location);
						var locPinSTR = answer.results[0].location.latitude + ";" + answer.results[0].location.longitude;
						$("#"+idFieldMap).val(locPinSTR);   // E' UN DIV -> rasformare in input nascosto (come checkbox)
					}
			};
			searchManager.geocode(requestOptions);
		});
		
	}
	
	FPMap.getLocation = function(){
		return (this.pin.getLocation());
	}
	
	// Class FPMap ----------------------------------------------------------------------------------------------------------------------------------------
		
	function MapDragEnd(evt){
		if (evt.targetType == 'pushpin'){
			var loc = evt.target.getLocation();
			alert("The location of the pushpin is now " + loc.latitude + ", " + loc.longitude);
		}
	}
	

	function _allowDrop_icon(ev) {
		ev.preventDefault();
	}
	

	function _drop_icon(ev) {
		ev.preventDefault();
	
		var tId = ev.target.id;
		var mainId = tId.substring(8);
		
      file = ev.dataTransfer.files[0];
		// alert ("file (name):"+file.name);
		// alert ("file (size):"+file.size);
	  var fileReader = new FileReader();
      fileReader.onload = (function(file) {
         return function(ev) {
				data = ev.target.result;
					$("#_id_prew"+mainId).attr("src", data);
					// $("#_id_text"+mainId).attr("value", data);
					$("#_id_text"+mainId).val(data);
            };
         })(file);
		fileReader.readAsDataURL(file);
	}
	
	// Function for Class DBSearch
	function _goSearch(t, tbRef, tbKey, tbDescr, callFunc ){	
		var formData = new FormData();

		// formData.append("tValue", t.value);
		formData.append("tbRef", tbRef);
		formData.append("tbKey", tbKey);
		formData.append("tbDescr", tbDescr);
	
	}
	
	
	
	function saveRecord(frmName, tblName, callBackFunc){	
	
	    $(".form-group").removeClass("has-warning");
	    $(".form-control").removeClass("form-control-warning");
	    $("._help").hide();
		
	    $(function () {
			// $('[data-toggle="popover"]').popover('dispose');   // OK in v4 (not exist method destroy in v4)
			// $('[data-toggle="popover"]').popover('destroy');   // OK in v3 (not exist method dispose in v3)
			$('[data-toggle="popover"]').popover('hide');   // this method exist in v3 e v4   BUT IS NOT EFFICIENT LIKE dispose or destroy
		})
		 
		if ( testRequired(frmName) ) return false;

		/*	
	    $(function () {
			$('[data-toggle="tooltip"]').tooltip('dispose');
		})
		*/
		
		var formData = new FormData($('#'+frmName)[0]);
		
		// formData.append('file', $('input[type=file]')[0].files[0]);
		formData.append('_ACT_', '_Save_');
		formData.append('_FORM_', frmName);
		formData.append('_TABLE_', tblName);
		
		$(".fileinput-filename").each(function(){
				var idOnDb = 	$(this).attr("id");
				// var textOnDb = $(this).val();
				// var textOnDb = $(this).contents();
				var textOnDb = $(this).text();
				formData.append(idOnDb, textOnDb);
		});
		
		// formData.append('file', $('input[type=file]')[0].files[0]);
		
		$.ajax({
			type: "POST",
			url: "_fePost.php",
			data: formData,
	     	// dataType: "json",
			//use contentType, processData for sure.
			contentType: false,
			processData: false,
			success: function(data) {
				
				if ( isJson(data) ) {
					var objJSON = JSON.parse(data);
					if (objJSON.Err.Status){
						for (i=0; i<objJSON.Err.FIELD.length; i++){
							// $("#_id_"+frmName+"_"+objJSON.Err.FIELD[i]).addClass("errorInput");
							/* until 24.01
							$( "#_id_"+frmName+"_"+objJSON.Err.FIELD[i] ).offsetParent().addClass("has-warning");    // boxInput
							$( "#_id_"+frmName+"_"+objJSON.Err.FIELD[i] ).addClass("form-control-warning");          // Field
							$("#_id_"+frmName+"_"+objJSON.Err.FIELD[i]).popover("show");
							*/
							$( "#_id"+objJSON.Err.FIELD[i] ).offsetParent().addClass("has-warning");    // boxInput
							$( "#_id"+objJSON.Err.FIELD[i] ).addClass("form-control-warning");          // Field
							$( "#_id"+objJSON.Err.FIELD[i] ).popover("show");
						}
						AlertForm(frmName, "ERR", "Fields not valid "+objJSON.Err.DESCR);
					}else{
						AlertForm(frmName, "OK", "Record Saved ");
						
						/*
						if (objJSON.ID.Value > 0){
							for (i=0; i<objJSON.ID.Key.length; i++){
								// alert (objJSON.ID.Key[i]);	
								$(objJSON.ID.Key[i]).value=objJSON.ID.Value;
							}
						}
						*/
						
						for (i=0; i<objJSON.Key.length; i++){
							// alert (objJSON.Key[i]["name"]+ ' - '+objJSON.Key[i]["value"]);	
							//$("#_pkUserName").val("f.rossi");
							$("#_pk"+objJSON.Key[i]["name"]).val(objJSON.Key[i]["value"]);
						}
						/*
						$( "input" ).each(function(){
								$(this).attr("compose");
							})
						*/
						if (objJSON.ID.Value > 0){
							$( "input[pk*='auto']" ).val( objJSON.ID.Value );
						}	
						
						var fn = window[callBackFunc];
						if (typeof fn === "function") fn.call(null, objJSON);
						
					}
				}else{
				 	AlertForm(frmName, "ERR", "Data not valid  !!<br/>"+data);
				}
			},
			error: function() {
				AlertForm(frmName, "ERR", "Generic ERROR !!");
			}
		});
	
	}
	
	
