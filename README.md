# FormEasy (Build your Form in easy way with XML)

FormE is a php class for manage tables in MySql Databases. Create your own form only manipulating xml files.
Lot of component, help you to write your form. 

Input, password, date, checkbox, radio, Bing map, linked combobox and so on in Bootstrap framework, use template for personalize input.

You can see [examples](http://www.shooney.com/forme/index.php) here. 

## Usage

### First of all: 
- Look at main_v3.php or main_v4.php for .CSS, .JS, linked file and .PHP to include in your main page (v3 and v4 referres to Bootstrap 3 and Bootstrap 4[alpha] frameworks).
- Create an instance of a class: 
```          $myForm = new Forms("myXML.xml", "ID=1");  ```


### Then create your xml (myXML.xml) file:

```<?xml version="1.0" encoding="UTF-8"?>```


### Add "form" Tag :

```<form name="frmAnagrafica" class="form-horizontal" x-table="Anagrafica" x-layout="desktops">```
- name = name of form 
- class = form-horizontal or none 
- x-table = table of mysql database
- x-layout = phones (col-xs-), tablets (col-sm-), desktops (col-md-), larger (col-lg-)


### Draw your grid :
form type "block"
```
<row x-col="10" style="..." class="..." >
   <boxInput x-col="2" style="..." class="...">
   </boxInput>
   <boxInput x-col="3">
   </boxInput>
   <boxInput x-col="5">
   </boxInput>
</row>	

<row x-col="10" style="...">
   <boxInput x-col="2">
   </boxInput>
   <boxInput x-col="2" style="..." class="...">
   </boxInput>
   <boxInput x-col="2">
   </boxInput>
   <boxInput x-col="2" class="...">
   </boxInput>
   <boxInput x-col="2">
   </boxInput>
</row>
```
form type "horizontal" is quite different 
```
<boxInput x-col="9">
	<label x-col="2">Avatar</label>
	<DBIcon x-col="3" style="width:150px; height:150px">ANAAvatar2</DBIcon>
</boxInput>

<boxInput x-col="9">
	<label x-col="2">ID</label>
	<DBInput x-col="1">ANAId</DBInput> 
</boxInput>
```
optionally use "style" and/or "class" for personalize yours tags 


### Insert your Input Type in boxInput, examples:

```
  <label>Name</label>
  <DBInput placeholder="Name" required="required">ANAName
	<help x-title="Name">Insert the Name...</help>
  </DBInput> 
```
OR
```
  <label>Name</label> 
  <DBInput2 placeholder="Name" x-image="user">ANAName</DBInput2> 
```
OR
```
  <label>Birthday</label>
  <DBDateIT>ANADtNasc</DBDateIT> 
```
... FINALLY insert DBApply tag  for send data in MySql Database 
```
  <DBApply>Salva</DBApply>
```


## Input Type 

### General information

- in input tag, the "name" and "id", is assigned automatically by system. Is not possible assign your own.
- attribute "x-" are particulary of the system, and add information at the corresponding HTML tag

### Label:
```
   <label>Name</label>
```
label of Input

### DBInput
```
   <DBInput placeholder="Name" required="required" >ANAName
     <help x-title="Name title">Insert Name ...</help>
   </DBInput> 
				
   <DBInput size="20" data-mask='099.099.099.099' placeholder="To IP">IPEnd
     <help x-title="IP">Insert IP in range of 192.168.0.1-192.168.0.254 !!!</help>
   </DBInput>
```
- placeholder : placeholder of input (optional)
- required : "required", if specified and not present in form, display the text in "help" tag (optional)
- x-valid : x-valid="test" a callable javascript function "test(this)" when change the value of tag. (optional)
- data-mask : refer to [igorescobar - plugin](http://igorescobar.github.io/jQuery-Mask-Plugin/docs.html) (optional)
- ANAName/IPEnd: Corresponding column in MySql Table specified in form->x-table

### DBInput2 
```
   <DBInput2 placeholder="Nome" x-image="user">ANANome</DBInput2> 
```
like input with image 
- x-image = specify the icon at the left of input [fontawesome](http://fontawesome.io/icons/)

### DBDateIT / DBDateEN
```
   <DBDateEN data-defaultViewDate="today">ANADtIscr</DBDateEN> 
```
Input date with notation dd-mm-yyyy (IT)  or mm/dd/yyyy (EN).
It is possible specify many other parameters according with [bootstrap-datepicker](https://bootstrap-datepicker.readthedocs.io/en/latest/options.html#)

### DBCheck
```
   <DBCheck x-descr="Rock"    x-states="Rock|norock">ANAmuRock</DBCheck>
   <DBCheck x-descr="Disco"   x-states="Yes|No">ANAmuDisco</DBCheck>
   <DBCheck x-descr="Lyrics"  x-states="1|0">ANAmuClas</DBCheck>
```
- x-descr = Description of checkbox
- x-states = Value True and False to write in Database (syntax:True|False)

### DBRadio
```
   <DBRadio>ANATipo
     <option value="CA">Caucasico</option>
     <option value="AS">Asiatico</option>
     <option value="AF">Africano</option>
     <option value="MO">Mongolico</option>
     <option value="AM">Americano</option>
</DBRadio>	
```

### DBComboBox
```
   <DBComboBox size="1" placeholder="Dug">ANAGR_DUGId
     <DBOption x-tbRef="Dug" x-tbKey="DUGId" x-tbDescr="DUGDescr" x-tbOrder="DUGDescr"></DBOption>
   </DBComboBox>	
```
DBOption parameters
- x-tbRef = Linked table in MySql Database
- x-tbKey = Key of linked table that match with value of tag DBComboBox
- x-tbDescr = Value of field (of linked Table) to show in combobox 
- x-tbOrder = Order to linked table

(select * from Dug where Dug.DUGId=ANAGR.ANAGR_DUGId order by Dug.DUGDescr)


### DBComboBoxCascade
```
   <boxInput x-col="2">
     <label>Continente</label>
     <DBComboBoxCascade size="1" placeholder="Continenti" x-cbCascade="grpAA" x-valid="showMap">ANAG_COId
        <DBOption x-tbRef="Continenti" x-tbKey="COId" x-tbDescr="CODescr" x-tbOrder="CODescr"></DBOption>
     </DBComboBoxCascade>	
   </boxInput>
	
   <boxInput x-col="2">
     <label>Stato</label>
     <DBComboBoxCascade size="1" placeholder="Stato" x-cbCascade="grpAA" required="required" x-valid="showMap">ANAG_STId  
        <DBOption x-tbRef="Stato" x-tbKey="STId" x-tbDescr="STDescr" x-tbOrder="STDescr" x-tbParentKey="COId"></DBOption>
     </DBComboBoxCascade>	
   </boxInput>
			
   <boxInput x-col="3">
     <label>Citta</label>
     <DBComboBoxCascade size="1" placeholder="Citta" x-cbCascade="grpAA" x-valid="showMap">ANAG_CTId
        <DBOption x-tbRef="Citta" x-tbKey="CTId" x-tbDescr="CTDescr" x-tbOrder="CTDescr" x-tbParentKey="STId"></DBOption>
     </DBComboBoxCascade>	
   </boxInput>
```
DbComboBoxCascade is an extension of DbComboBox and use for linked combobox			
- x-cbCascade = Identifier of linked group of combobox (obbligatory), the order in xml file is important !
DBOption
- x-tbRef/x-tbKey/x-tbDescr/x-tbOrder = like in DBOption of DBComboBox
- x-tbParentKey =  Key of linked table to parent Table 

example Stato: (select * from Stato where Stato.STId=ANAGR.ANAG_STId and Stato.COId=ANAGR.ANAG_COId order by Stato.STDescr)

### DBSearch
```
   <DBSearch placeholder="Search..." x-valid="showSearch" x-SearchTable='Stato' x-SearchField='STDescr' x-SearchReturn='STDescr'>ANASearch
     <DBSearchReturn>
	<span>
	  <img src="img/@STFlag@"/>  @STDescr@
	</span>
     </DBSearchReturn>  
   </DBSearch> 
```
DBSearch is a text control that auto-populate in according with text entered

- x-SearchTable = MySql table
- x-SearchField = Fields of MySql table with a values of search
- x-SearchReturn = Return value in field text
- x-valid = user javascript function 

DBSearchReturn: contain a block of data for populate the window that appear in bottom at text control, it is crypted with a key that you have specified in FormE.ini.php

### DBSearch
```
   <DBInputFile placeholder="File" x-upload="upload2">ANAlinkFile1</DBInputFile> 
```
Upload a File 
- x-upload = Directory where the file are uploaded, if not specified the default value is stored in FormE.ini.php

### DBMapBing
```
   <DBMapBing style="width:400px; height:400px">ANAMap</DBMapBing> 
```
Show a map in your page. Look the examples for a simple use of that control. 

### DBIcon
```
   <DBIcon style="width:150px; height:150px" x-descr="[drag here !!]">ANAAvatar2</DBIcon>
```
Small images in MySql table, use LONGTEXT. Drag and Drop into this control 

### DBTextArea
```
   <DBTextArea rows="8" cols="200">ANANote</DBTextArea>
```

+1)



