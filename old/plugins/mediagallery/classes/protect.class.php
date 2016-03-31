<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: classes/protect.class.php                        |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

require_once(dirname(__FILE__)."/resize.class.php");

class Protector extends Resizer{
	
	var $ProtectType;
	var $Font;
	var $FontSize;
	var $FontAngle;
	var $Text;
	var $Wmark;
	var $WmarkSize;

	function ProtectImage($Type){
		$this->ProtectType = $Type;
		if ($this->ProtectType == 1){
			$this->TextProtection();
		}else{
			$this->WmarkProtection();
		}
	}
	
	function WmarkProtection(){
		global $pref;
		$Image = e_WMARKS.$pref['mg_protect_image'];
		$this->WmarkSize = @getimagesize($Image);
		if ($this->WmarkSize[2] == 1){
			$this->Wmark = imagecreatefromgif($Image);
		}elseif ($this->WmarkSize[2] == 2){
			$this->Wmark = imagecreatefromjpeg($Image);
		}elseif ($this->WmarkSize[2] == 3){
			$this->Wmark = imagecreatefrompng($Image);
		}elseif ($this->WmarkSize[2] == 6){
			$this->Wmark = $this->ImageCreateFromBMP($Image);
		}
		list($OffsetX, $OffsetY) = $this->SetPosition($pref['mg_protect_pos'], $pref['mg_protect_offset']);
		if ($this->GdVersion >= 2){
			imagealphablending($this->Image, TRUE);
			imagecopy($this->Image, $this->Wmark, $OffsetX, $OffsetY, 0, 0, $this->WmarkSize[0], $this->WmarkSize[1]);
		}else{
			imagecopymerge($this->Image, $this->Wmark, $OffsetX, $OffsetY, 0, 0, $this->WmarkSize[0], $this->WmarkSize[1], 100);
		}
		imagedestroy($this->Wmark);
	}

	function TextProtection(){
		global $pref;
		$this->Text = $this->SetCharset($pref['mg_protect_text']);
		$this->FontSize = $pref['mg_protect_fontsize'];
		$this->FontAngle = $pref['mg_protect_fontangle'];
		if (!SAFE_MODE){ // Самый надёжный способ
			putenv("GDFONTPATH=".realpath(dirname($pref['mg_protect_font'])));
			$this->Font = substr(basename($pref['mg_protect_font']), 0, -4);
		}else{ // Менее надёжный, на случай, если включён безопастный режим
			$this->Font = realpath($pref['mg_protect_font']);
		}
		preg_match("/^#?([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})$/i", $pref['mg_protect_fontcolor'], $Rgb);
		$Color = imagecolorallocate($this->Image, hexdec($Rgb[1]), hexdec($Rgb[2]), hexdec($Rgb[3]));
		list($OffsetX, $OffsetY) = $this->SetPosition($pref['mg_protect_pos'], $pref['mg_protect_offset']);
		imagettftext($this->Image, $this->FontSize, $this->FontAngle, $OffsetX, $OffsetY, $Color, $this->Font, $this->Text);
	}

	function SetCharset($Text){
		if (extension_loaded("iconv")){
			$Result = iconv(strtoupper(CHARSET), "UTF-8", $Text);
		}else{
			$Text = stristr(CHARSET, "win") ? convert_cyr_string($Text, 'w', 'i') : $Text;
			for ($Result = "", $i = 0; $i < strlen($Text); $i++){
				$Charcode = ord($Text[$i]);
				$Result .= ($Charcode > 175) ? "&#".(1040 + ($Charcode - 176)).";" : $Text[$i];
			}
		}
		return $Result;
	}

	function SetPosition($Posit, $Offset){
		$Positions = array("tl", "tm", "tr", "cl", "c", "cr", "bl", "bm", "br");
		if ($Posit == 9){
			$Position = $Positions[mt_rand(0, 8)];
		}else{
			$Position = $Positions[$Posit];
		}
		if ($this->ProtectType == 1){
			$Size = imagettfbbox($this->FontSize, $this->FontAngle, $this->Font, $this->Text);
			$MarkWidth = $Size[2]-$Size[0];
			$MarkHeight = $Size[1]-$Size[5];
		}else{
			$MarkWidth = $this->WmarkSize[0];
			$MarkHeight = $this->WmarkSize[1];
		}
		switch ($Position){
			case "tl":
				$OffsetX = $Offset;
				$OffsetY = $Offset;
				break;
			case "tm":
				$OffsetX = intval(($this->OldWidth-$MarkWidth)/2);
				$OffsetY = $Offset;
				break;
			case "tr":
				$OffsetX = $this->OldWidth-$MarkWidth-$Offset;
				$OffsetY = $Offset;
				break;
			case "cl":
				$OffsetX = $Offset;
				$OffsetY = intval(($this->OldHeight-$MarkHeight)/2);
				break;
			case "c":
				$OffsetX = intval(($this->OldWidth-$MarkWidth)/2);
				$OffsetY = intval(($this->OldHeight-$MarkHeight)/2);
				break;
			case "cr":
				$OffsetX = $this->OldWidth-$MarkWidth-$Offset;
				$OffsetY = intval(($this->OldHeight-$MarkHeight)/2);
				break;
			case "bl":
				$OffsetX = $Offset;
				$OffsetY = $this->OldHeight-$MarkHeight-$Offset;
				break;
			case "bm":
				$OffsetX = intval(($this->OldWidth-$MarkWidth)/2);
				$OffsetY = $this->OldHeight-$MarkHeight-$Offset;
				break;
			case "br":
				$OffsetX = $this->OldWidth-$MarkWidth-$Offset;
				$OffsetY = $this->OldHeight-$MarkHeight-$Offset;
				break;
			default:
				$OffsetX = $Offset;
				$OffsetY = $Offset;
				break;
		}
		if ($this->ProtectType == 1){
			$OffsetY += $MarkHeight;
		}
		return array($OffsetX, $OffsetY);
	}

}

?>