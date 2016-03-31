<!--

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: mediagallery.js                                  |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

var ImageTooltip;
var ColorField;

function RestrictDir(){
	if (document.getElementById('mode').value == 3){
		document.getElementById('dir').value = 0;
		document.getElementById('dir').disabled = true;
	}else{
		document.getElementById('dir').disabled = false;
	}
}

function CheckBox(Num, Mode){
	for (var I=0; I<Num; I++){
		if (Mode == 1){
			document.getElementById('action'+I).checked = true;
		}else{
			document.getElementById('action'+I).checked = false;
		}
	}
}

function ProfPrefs(){
	if (document.getElementById('mg_mode_prof1').checked){
		for (var I=1; I<6; I++){
			document.getElementById('profprefs_'+I).style.display = "";
		}
		if (document.getElementById('mg_protect_type0').checked){
			document.getElementById('profprefs_6').style.display = "";
			for (var I=7; I<12; I++){
				document.getElementById('profprefs_'+I).style.display = "none";
			}
		}else{
			document.getElementById('profprefs_6').style.display = "none";
			for (var I=7; I<12; I++){
				document.getElementById('profprefs_'+I).style.display = "";
			}
			if (document.getElementById('wmark_upload').style.display == ""){
				document.getElementById('wmark_upload').style.display = "none";
			}
		}
	}else{
		for (var I=1; I<12; I++){
			document.getElementById('profprefs_'+I).style.display = "none";
		}
		if (document.getElementById('wmark_upload').style.display == ""){
			document.getElementById('wmark_upload').style.display = "none";
		}
	}
}

function UserCat(){
	if (document.getElementById('mg_create_forcename').checked == true){
		document.getElementById('mg_create_limit').value = 1;
		document.getElementById('mg_create_limit').disabled = true;
	}else{
		document.getElementById('mg_create_limit').disabled = false;
	}
}

function GetPosition(Object){
	var Position = {left:0, top:0};
	Position.left = Object.offsetLeft;
	Position.top = Object.offsetTop;
	if (Object.offsetParent != null){
    	var ParentPosition = {left:0, top:0};
    	ParentPosition = GetPosition(Object.offsetParent);
    	Position.left += ParentPosition.left;
    	Position.top += ParentPosition.top;
	}
	return Position;
}

function ColorChooser(Id){
	var ColorChooser = document.getElementById("colorchooser");
	if (ColorChooser.style.visibility == "hidden"){
		ColorField = document.getElementById(Id+"text");
		var Position = GetPosition(document.getElementById(Id+"button"));
		var Height = document.getElementById(Id+"button").offsetHeight;
		ColorChooser.style.left = Position.left+"px";
		ColorChooser.style.top = Position.top+Height+"px";
		ColorChooser.style.visibility = "visible";
	}else{
		ColorChooser.style.visibility = "hidden";
		ColorChooser.style.left = "-1000px";
	}
}

function SelectColor(Color){
	ColorField.value = Color;
}

function ShowTooltip(Id){
	ImageTooltip = document.getElementById(Id+"tooltip");
	var Position = GetPosition(document.getElementById(Id+"button"));
	if (Id == "prev"){
		var OffSetY = -document.getElementById("prevtooltip").offsetHeight;
		var OffSetX = -document.getElementById("prevtooltip").offsetWidth;
	}else{
		var OffSetY = -document.getElementById("nexttooltip").offsetHeight;
		var OffSetX = document.getElementById("nextbutton").offsetWidth;
	}
	ImageTooltip.style.left = Position.left+OffSetX+"px";
	ImageTooltip.style.top = Position.top+OffSetY+"px";
	ImageTooltip.style.visibility = "visible";
}

function HideTooltip(){
	ImageTooltip.style.visibility = "hidden";
	ImageTooltip.style.left = "-1000px";
}

//-->