<?php
class gblibrary extends Database 
{
	public $squery;
	public $resultset;
	public $recordset;
	public $numrecords;
	public $cityId,$stateId,$itemId,$userId;
	public $cityName,$activeCity,$userName,$userEmail,$userPassword;
	
	function fetch_num_rows()
	{
		//echo $this->squery;
		$this->resultset	=mysql_query($this->squery) or die(mysql_error());		
		$this->numrecords	=mysql_num_rows($this->resultset);
	}
	function getReferenceId()
	{
		$this->squery="SELECT reference_id FROM tbl_user_mst WHERE user_id='".$this->userId."'";
		$this->select($this->squery);
		$this->reference_id=$this->result[0]['reference_id'];
	}
	
	
	function _getComboValueSelected($actualValue,$displayValue,$selectedValue='')
	{
		$this->comboActualValue		=$actualValue;
		$this->comboDisplayValue	=$displayValue;
		$this->comboSelectedValue	=$selectedValue;
		$this->comboValues="";
		$this->select($this->squery);
		$this->fetch_num_rows();
		for($i=0;$i<$this->numrecords;$i++)
		{
			if($this->comboSelectedValue==$this->result[$i][$this->comboActualValue])
			{
				$selected='selected="selected"';
			}
			else
			{
				$selected='';	
			}
			$this->comboValues=$this->comboValues."<option value=".$this->result[$i][$this->comboActualValue]." ".$selected.">".$this->result[$i][$this->comboDisplayValue]."</option>";		
			
		}
	}
	
		
	function generate_password()
	{
		//settings
		$chars="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz!@#$%^";
		$minchars=6;
		$maxchars=8;	
		//rest of script
		$escapecharplus=0;
		$repeat=mt_rand($minchars,$maxchars);
		while ($escapecharplus<$repeat)
		{
			$randomword.=$chars[mt_rand(1, strlen($chars)-1)];
			$escapecharplus+=1;
		}
		$this->generateRandomword=$randomword;
	}
	
	
	
	

	

	
	
	function convert_seo_name()
	{
		
		$this->seoName=str_replace(" ","-",$this->seoName);
		$this->seoName=str_replace("  ","-",$this->seoName);
		$this->seoName=str_replace("'","",$this->seoName);
		$this->seoName=str_replace("+","-",$this->seoName);
		$this->seoName=str_replace("&","-and-",$this->seoName);
		$this->seoName=str_replace('"',"-",$this->seoName);
		$this->seoName=str_replace("/","-",$this->seoName);
		$this->seoName=str_replace("---","-",$this->seoName);
		$this->seoName=str_replace("--","-",$this->seoName);
		$this->seoName=str_replace(".","-",$this->seoName);
		return $this->seoName;
	}
	
	function resize_image1($file,$ext, $w, $h, $path) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
	if($ext=="jpg" || $ext=="JPG" || $ext=="jpeg" || $ext=="JPEG")
	{
		$src = imagecreatefromjpeg($file);
		
	}
	else if($ext=="gif" || $ext=="GIF")
	{
		$src = imagecreatefromgif($file);
		
	}
	else if($ext=="png" || $ext=="PNG")
	{
		$src = imagecreatefrompng($file);
		
	}
	else
	{
		echo "Incorrect file extentstion";	
	}
	$newwidth = $w;
	$newheight = $h;
    $dst = imagecreatetruecolor($newwidth, $newheight);
	imagecolortransparent($dst, $white);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	if($ext=="jpg" || $ext=="JPG" || $ext=="jpeg" || $ext=="JPEG")
	{
		imagejpeg($dst,$path);
		
	}
	else if($ext=="gif" || $ext=="GIF")
	{
		imagegif($dst,$path);
		
	}
	else if($ext=="png" || $ext=="PNG")
	{
		
		imagepng($dst,$path);
		
	}
	else
	{
		echo "Incorrect file extentstion";	
	}
    //return $dst;
	return 1;
}
	
	

}	
?>