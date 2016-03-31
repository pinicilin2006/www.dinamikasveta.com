<?php

/*
+---------------------------------------------------------------+
|        e107 website system                                    |
|        ©Steve Dunstan 2001-2002                               |
|        http://jalist.com                                      |
|        stevedunstan@jalist.com                                |
|                                                               |
|        File: classes/resize.class.php                         |
|        Plugin: Media gallery                                  |
|        Author: soulhunter (darksport@users.mns.ru)            |
|                                                               |
|        Released under the terms and conditions of the         |
|        GNU General Public License (http://gnu.org).           |
+---------------------------------------------------------------+
*/

defined("e107_INIT") or exit;

if (function_exists("include_lan")){
	include_lan(dirname(__FILE__)."/../languages/".e_LANGUAGE."/lan_resize.class.php");
}

class Resizer{

	var $GdVersion;
	var $Image;
	var $OldWidth;
	var $OldHeight;
	var $NewWidth;
	var $NewHeight;

	function ResizeImage($SourceFile, $DestinationFile, $NewWidth, $NewHeight, $Protect = FALSE){
		global $pref;
		ini_set("memory_limit", -1);
		@chmod($SourceFile, octdec(777));
		$this->GdVersion = $this->GetGdVersion();
		$ImageInfo = @getimagesize($SourceFile);
		$this->OldWidth = $ImageInfo[0];
		$this->OldHeight = $ImageInfo[1];
		list($this->NewWidth, $this->NewHeight) = $this->CalculateSize($this->OldWidth, $this->OldHeight, $NewWidth, $NewHeight);
		switch ($ImageInfo[2]){
			case 1:
				$this->Image = imagecreatefromgif($SourceFile);
				break;
			case 2:
				$this->Image = imagecreatefromjpeg($SourceFile);
				break;
			case 3:
				$this->Image = imagecreatefrompng($SourceFile);
				break;
			case 6:
				$this->Image = $this->imagecreatefrombmp($SourceFile);
				break;
			default:
				echo MG_RESIZE_CLASS_1;
				return FALSE;
		}
		if (!$this->Image){
			echo MG_RESIZE_CLASS_2;
			return FALSE;
		}
		if ($Protect){
			$this->ProtectImage($pref['mg_protect_type']);
		}
		if ($this->GdVersion >= 2){// GD версии 2 позволяет сохранять прозрачность во всех изображениях ;)
			$TemporaryImage = imagecreatetruecolor($this->NewWidth, $this->NewHeight);
			imagealphablending($TemporaryImage, FALSE);
			$Color = imagecolorallocate($TemporaryImage, 0, 0, 0);
			imagecolortransparent($TemporaryImage, $Color);
			imagecopyresampled($TemporaryImage, $this->Image, 0, 0, 0, 0, $this->NewWidth, $this->NewHeight, $this->OldWidth, $this->OldHeight);
			if ($ImageInfo[2] == 3){
				imagesavealpha($TemporaryImage, TRUE);
			}
		}else{
			$TemporaryImage = imagecreate($this->NewWidth, $this->NewHeight);
			$Color = imagecolorallocate($TemporaryImage, 0, 0, 0);
			imagecolortransparent($TemporaryImage, $Color);
			imagecopyresized($TemporaryImage, $this->Image, 0, 0, 0, 0, $this->NewWidth, $this->NewHeight, $this->OldWidth, $this->OldHeight);
		}
		$Funcs = array(1 => "imagegif", 2 => "imagejpeg", 3 => "imagepng", 6 => "imagejpeg");
		if ($DestinationFile == "stdout"){
			header("Content-type: ".$ImageInfo['mime']);
			$Funcs[$ImageInfo[2]]($TemporaryImage, NULL, $pref['mg_resize_quality']);
		}else{
			$Funcs[$ImageInfo[2]]($TemporaryImage, $DestinationFile, $pref['mg_resize_quality']);
		}
		imagedestroy($TemporaryImage);
		imagedestroy($this->Image);
		@chmod($SourceFile, octdec(666));
		if ($DestinationFile != "stdout"){
			@chmod($DestinationFile, octdec(666));
			$ImageStats = @getimagesize($DestinationFile);
			if ($ImageStats == NULL){
				@unlink($DestinationFile);
				echo MG_RESIZE_CLASS_2;
				return FALSE;
			}else{
				return TRUE;
			}
		}
	}

	function CalculateSize($OldWidth, $OldHeight, $NewWidth, $NewHeight){
		$Width = $NewWidth;
		$Height = $NewHeight;
		if ($OldWidth <= $NewWidth && $OldHeight <= $NewHeight){
			$Width = $OldWidth;
			$Height = $OldHeight;
		}
		if ($OldWidth > $NewWidth || $OldHeight > $NewHeight){
			$WidthRatio = $OldWidth/$NewWidth;
			$HeightRatio = $OldHeight/$NewHeight;
			if ($WidthRatio > $HeightRatio){
				$Width = $NewWidth;
				$Height = $OldHeight/$WidthRatio;
			}else{
				$Width = $OldWidth/$HeightRatio;
				$Height = $NewHeight;
			}
		}
		$Width = round($Width);
		$Height = round($Height);
		return array($Width, $Height);
	}

	function imagecreatefrombmp($FileName){
		if (!$F1 = @fopen($FileName, "rb")){
			return FALSE;
		}
		$File = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($F1, 14));
		if ($File['file_type'] != 19778){
			return FALSE;
		}
		$Bmp = unpack("Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel"."/Vcompression/Vsize_bitmap/Vhoriz_resolution"."/Vvert_resolution/Vcolors_used/Vcolors_important", fread($F1, 40));
		$Bmp['colors'] = pow(2, $Bmp['bits_per_pixel']);
		if ($Bmp['size_bitmap'] == 0){
			$Bmp['size_bitmap'] = $File['file_size']-$File['bitmap_offset'];
		}
		$Bmp['bytes_per_pixel'] = $Bmp['bits_per_pixel']/8;
		$Bmp['bytes_per_pixel2'] = ceil($Bmp['bytes_per_pixel']);
		$Bmp['decal'] = ($Bmp['width']*$Bmp['bytes_per_pixel']/4);
		$Bmp['decal'] -= floor($Bmp['width']*$Bmp['bytes_per_pixel']/4);
		$Bmp['decal'] = 4-(4*$Bmp['decal']);
		if ($Bmp['decal'] == 4){
			$Bmp['decal'] = 0;
		}
		$Palette = array();
		if ($Bmp['colors'] < 16777216){
			$Palette = unpack("V".$Bmp['colors'], fread($F1, $Bmp['colors']*4));
		}
		$Img = fread($F1, $Bmp['size_bitmap']);
		$Vide = chr(0);
		if ($this->GdVersion >= 2){
			$Res = imagecreatetruecolor($Bmp['width'], $Bmp['height']);
		}else{
			$Res = imagecreate($Bmp['width'], $Bmp['height']);
		}
		$P = 0;
		$Y = $Bmp['height']-1;
		while ($Y >= 0){
			$X=0;
			while ($X < $Bmp['width']){
				if ($Bmp['bits_per_pixel'] == 24){
					$Color = unpack("V", substr($Img, $P, 3).$Vide);
				}elseif ($Bmp['bits_per_pixel'] == 16){
					$Color = unpack("n", substr($Img, $P, 2));
					$Color[1] = $Palette[$Color[1]+1];
				}elseif ($Bmp['bits_per_pixel'] == 8){
					$Color = unpack("n", $Vide.substr($Img, $P, 1));
					$Color[1] = $Palette[$Color[1]+1];
				}elseif ($Bmp['bits_per_pixel'] == 4){
					$Color = unpack("n", $Vide.substr($Img, floor($P), 1));
					if (($P*2)%2 == 0) $Color[1] = ($Color[1] >> 4);
					else $Color[1] = ($Color[1] & 0x0F);
					$Color[1] = $Palette[$Color[1]+1];
				}elseif ($Bmp['bits_per_pixel'] == 1){
					$Color = unpack("n", $Vide.substr($Img, floor($P), 1));
					if (($P*8)%8 == 0){
						$Color[1] = $Color[1]>>7;
					}elseif (($P*8)%8 == 1){
						$Color[1] = ($Color[1] & 0x40)>>6;
					}elseif (($P*8)%8 == 2){
						$Color[1] = ($Color[1] & 0x20)>>5;
					}elseif (($P*8)%8 == 3){
						$Color[1] = ($Color[1] & 0x10)>>4;
					}elseif (($P*8)%8 == 4){
						$Color[1] = ($Color[1] & 0x8)>>3;
					}elseif (($P*8)%8 == 5){
						$Color[1] = ($Color[1] & 0x4)>>2;
					}elseif (($P*8)%8 == 6){
						$Color[1] = ($Color[1] & 0x2)>>1;
					}elseif (($P*8)%8 == 7){
						$Color[1] = ($Color[1] & 0x1);
					}
					$Color[1] = $Palette[$Color[1]+1];
				}else{
					return FALSE;
				}
				imagesetpixel($Res, $X, $Y, $Color[1]);
				$X++;
				$P += $Bmp['bytes_per_pixel'];
			}
			$Y--;
			$P+=$Bmp['decal'];
		}
		fclose($F1);
		return $Res;
	}

	function GetGdVersion(){
		$GdInfo = gd_info();
		preg_match("/(\d)\.\d/", $GdInfo['GD Version'], $GdInfo);
		return $GdInfo[1];
	}

}

?>