# FormEasy (Build your Form in easy way with XML)

FormE is a php class for manage tables in MySql Databases. Create your own form only manipulating xml files.
Lot of component, help you to write your form in easy mode.

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



