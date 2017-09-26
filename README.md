# FormE
FormEasy (Build your Form in easy way with XML)

Manage your MySql database with FormE, and create your own form only manipulating xml files.Lot of component, help you to write your form in easy mode.

Input, password, date, checkbox, radio, Bing map, linked combobox and so on in Bootstrap framework, use template for personalize input.


## Usage
###Create your xml file :

```<?xml version="1.0" encoding="UTF-8"?>```

###Add "form" Tag :

```<form name="frmAnagrafica" class="form-horizontal" x-table="Anagrafica" x-layout="desktops">```
- name = name of form 
- class = form-horizontal or none 
- x-table = table of mysql database
- x-layout = phones (col-xs-), tablets (col-sm-), desktops (col-md-), larger (col-lg-)

###Draw your grid :
```
<row x-col="10" style="..." class="..." >
   <boxInput x-col="2" style="..." class="...">
   </boxinput>
   <boxInput x-col="3">
   </boxinput>
   <boxInput x-col="5">
   </boxinput>
</row>	

<row x-col="10" style="...">
   <boxInput x-col="2">
   </boxinput>
   <boxInput x-col="2" style="..." class="...">
   </boxinput>
   <boxInput x-col="2">
   </boxinput>
   <boxInput x-col="2" class="...">
   </boxinput>
   <boxInput x-col="2">
   </boxinput>
</row>
```
optionally use "style" and/or "class" for personalize yours tag 
