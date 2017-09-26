# FormE
FormEasy (Build your Form in easy way with XML)

Manage your MySql database with FormE, and create your own form only manipulating xml files.
Lot of component, help you to write your form in easy mode.

Input, password, date, checkbox, radio, Bing map, linked combobox and so on in Bootstrap framework, use template for personalize input.


## Usage
### Create your xml file :

```<?xml version="1.0" encoding="UTF-8"?>```

### Add "form" Tag :

```<form name="frmAnagrafica" class="form-horizontal" x-table="Anagrafica" x-layout="desktops">```
- name = name of form 
- class = form-horizontal or none 
- x-table = table of mysql database
- x-layout = phones (col-xs-), tablets (col-sm-), desktops (col-md-), larger (col-lg-)

### Draw your grid :
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
  <DBApply x-callback="myFuncExit">Salva</DBApply>
```



