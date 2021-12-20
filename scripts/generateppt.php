<?php
ini_set('max_execution_time', '0'); // for infinite time of execution 
//ini_set('max_execution_time', 240);

//header("Content-Type: text/html;charset=UTF-8");
ob_start(); 
session_start();

/** Error reporting */
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


/** Include path **/
include_once '../includes/connect.php';
include_once '../includes/define.php';
include_once '../includes/functions.php';
include_once '../classes/PHPPowerPoint.php';


date_default_timezone_set('Asia/Calcutta'); 
set_include_path(get_include_path() . PATH_SEPARATOR . 'classes/');

//echo"typ==<pre>";print_r($_REQUEST);exit;

$arrData = array();

$ipaddress = getIPaddress();		// get user ip address GIEGMPL//	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_detail = IPDetails($ipaddress);
$ISPurl = ISPDetails($ipaddress);
$ISP = (!empty($ISPurl['isp'])?$ISPurl['isp']:"") ;

$message = "Generate PPT By ".$_SESSION['name'];
UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);



	$clientID = rtrim($_POST['hiddata'], ',');
	$appnd = " and rc.cmpid IN(".$clientID.") ORDER BY sequence ASC";
	
	
	$QUERY="SELECT rc.cmpid,rc.sequence,rc.cname,rc.cmpname,rc.cmpemail,rc.mobile,rc.role,rc.powerteam,rc.ptid,rc.website,rc.usp,rci.id AS imgid,
	rci.imgname,rci.imgpath FROM "._PREFIX."client rc
	JOIN "._PREFIX."client_img rci ON(rci.cmpid=rc.cmpid)
	WHERE rc.STATUS=1 and rc.cname<>'Admin' AND rci.`status`=1 and rc.cmpid IN(".$clientID.") ORDER BY sequence ASC ";	
	
	$result= mysqli_query($conn,$QUERY);
	$rows = mysqli_num_rows($result);



$i=0;
while($fetch_data=mysqli_fetch_array($result))
{
	$arrData[$i]['cname'] 		= $fetch_data['cname'];
	$arrData[$i]['sequence'] 	= $fetch_data['sequence'];
	$arrData[$i]['cmpname'] 	= $fetch_data['cmpname'];
	$arrData[$i]['cmpemail'] 	= $fetch_data['cmpemail'];
	$arrData[$i]['mobile'] 		= $fetch_data['mobile'];
	$arrData[$i]['role'] 		= $fetch_data['role'];
	$arrData[$i]['powerteam'] 	= $fetch_data['powerteam'];
	$arrData[$i]['ptid'] 		= $fetch_data['ptid'];
	$arrData[$i]['website'] 	= $fetch_data['website'];
	$arrData[$i]['usp'] 		= $fetch_data['usp'];	
	$arrData[$i]['imgname'] 	= $fetch_data['imgname'];
	$arrData[$i]['imgpath'] 	= $fetch_data['imgpath'];

$i++;

}
//exit;
  //echo"<pre>arrData==";print_r($arrData);exit;

// Create new PHPPowerPoint object
echo " Something went wrong! Please try again\n";
$objPHPPowerPoint = new PHPPowerPoint();



// Remove first slide
//echo date('H:i:s') . " Remove first slide\n";
$objPHPPowerPoint->removeSlideByIndex(0);


$imgpath = "";
// Create templated slide
// for static value first st page//

	//echo date('H:i:s') . " Create templated slide\n";
	$currentSlide = createTemplatedSlide($objPHPPowerPoint,$imgpath); // local function



	// Create a shape (text)
	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();
	
	$shape->setHeight(90);
	$shape->setWidth(890);
	$shape->setOffsetX(60);	// for content
	$shape->setOffsetY(290);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
	
	// BNI Champions text //
	$textRun = $shape->createTextRun("BNI CHAMPIONS");	
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(60);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FBFCFC' ) );

	$shape->createBreak();
	$shape->createBreak();

//echo"<pre>arrdat==";print_r($arrData);

// for dynamoc nvalue //

foreach($arrData as $value )
{
	$cname = ucwords($value['cname']);
	
	//$uspLimit = limitText($value['usp'],40);

	$uspLimit = $value['usp'];
	
	if($value['website']!="")
	{
		$web = explode("http://",$value['website']);
		if(isset($web[1])){ $website = $web[1];} else $website = $web[0];
		$webMsg = $website;
	}
	else
	{
		$webMsg = "+91-".$value['mobile'];
	}

	// Create templated slide
	//echo date('H:i:s') . " Create templated slide\n";
	
   // $value['imgpath'] = '../images/black-image.png';
	$currentSlide = createTemplatedSlide($objPHPPowerPoint,$value['imgpath']); // local function



	// Create a shape (text)
	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();
	
	$shape->setHeight(130);
	$shape->setWidth(490);
	$shape->setOffsetX(20);	// for content
	$shape->setOffsetY(90);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
	

	$textRun = $shape->createTextRun($cname);	
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(40);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FBFCFC' ) );

	$shape->createBreak();
	$shape->createBreak();
	
//$value['cmpname'] = htmlspecialchars_decode($value['cmpname'], ENT_QUOTES);
	//for company name //
	$textRun = $shape->createTextRun($value['cmpname']);
	

	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(24);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'E8DAEF' ) );

	$shape->createBreak();
	$shape->createBreak();
	


// Create a shape (text) for USP
	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();

	$shape->setHeight(250);
	$shape->setWidth(490);
	$shape->setOffsetX(35);	// for content
	$shape->setOffsetY(290);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
/*
	//for website name //
	$textRun = $shape->createTextRun('USP:');
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(28);	
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FBFCFC' ) );

	$shape->createBreak();

*/

	//for USP Details  //
	$textRun = $shape->createTextRun($uspLimit);
	

	$textRun->getFont()->setBold(false);
	$textRun->getFont()->setSize(24);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'D6EAF8' ) );

	$shape->createBreak();
	$shape->createBreak();


	// Create a shape (text) forwebsite//
	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();

	$shape->setHeight(500)
		  ->setWidth(540)
		  ->setOffsetX(210)
		  ->setOffsetY(630);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );

	//for website name //
	$textRun = $shape->createTextRun($webMsg);
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(28);
	
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'ECF0F1' ) );

	$shape->createBreak();
	
	

}

	// for static value last page//
	// Create a shape (text)

	//echo date('H:i:s') . " Create templated slide\n";
	$currentSlide = createTemplatedSlide($objPHPPowerPoint,$imgpath); // local function

	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();
	
	$shape->setHeight(90);
	$shape->setWidth(880);
	$shape->setOffsetX(60);	// for content
	$shape->setOffsetY(290);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
	
	// Late Comers //
	$textRun = $shape->createTextRun("LATE COMERS");	
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(60);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FBFCFC' ) );

	$shape->createBreak();
	$shape->createBreak();

	// Substitutes //

	//echo date('H:i:s') . " Create templated slide\n";
	$currentSlide = createTemplatedSlide($objPHPPowerPoint,$imgpath); // local function

	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();
	
	$shape->setHeight(90);
	$shape->setWidth(890);
	$shape->setOffsetX(60);	// for content
	$shape->setOffsetY(290);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );

	$textRun = $shape->createTextRun("SUBSTITUTES");	
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(60);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FBFCFC' ) );

	$shape->createBreak();
	$shape->createBreak();

	// BNI CHAMPIONS//
	//echo date('H:i:s') . " Create templated slide\n";
	$currentSlide = createTemplatedSlide($objPHPPowerPoint,$imgpath); // local function

	//echo date('H:i:s') . " Create a shape (rich text)\n";
	$shape = $currentSlide->createRichTextShape();
	
	$shape->setHeight(90);
	$shape->setWidth(890);
	$shape->setOffsetX(60);	// for content
	$shape->setOffsetY(290);
	
	$shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );

	$textRun = $shape->createTextRun("BNI CHAMPIONS");	
	
	$textRun->getFont()->setBold(true);
	$textRun->getFont()->setSize(60);
	$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FBFCFC' ) );

	$shape->createBreak();
	$shape->createBreak();




// Save PowerPoint 2007 file
//echo date('H:i:s') . " Write to PowerPoint2007 format\n";
$objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
//$objWriter->save(str_replace('.php', '.pptx', __FILE__));

// Echo memory peak usage
echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";

// Echo done
//echo date('H:i:s') . " Done writing file.\r\n";

$filename = str_replace('.php', '.pptx', __FILE__);
$newname = "PresentationReport-" . date('Y-m-d-H-i-s') . ".pptx";
$objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$objWriter->save(str_replace('.php', '.pptx', __FILE__));

// block to download file.
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

header("Content-Disposition: attachment;filename=" . $newname);
header('Content-Transfer-Encoding: binary');
header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
ob_clean();
flush();
readfile($filename);
//exit();


/**
 * Creates a templated slide
 *
 * @param PHPPowerPoint $objPHPPowerPoint
 * @return PHPPowerPoint_Slide
 */
function createTemplatedSlide(PHPPowerPoint $objPHPPowerPoint,$imgPath)
{
//echo"<li>path==".$imgPath;exit;
	// Create slide
	
	
	
	$slide = $objPHPPowerPoint->createSlide();
	
	// Add background image
    $slide->createDrawingShape()
          ->setName('Background')
          ->setDescription('Background')
          ->setPath('../images/background.jpg')
          ->setWidth(980)
          ->setHeight(720)
          ->setOffsetX(0)
          ->setOffsetY(0);

	if(!empty($imgPath)){
	// border//
	$slide->createDrawingShape()
          ->setName('Border Logo')
          ->setDescription('Border Logo')
          ->setPath('../images/border.jpg')
		  ->setResizeProportional(false)
          ->setWidth(960)
          ->setHeight(90)
          ->setOffsetX(0)
          ->setOffsetY(615);

	
    // Add logo
    $slide->createDrawingShape()
          ->setName('profile Logo')
          ->setDescription('profile logo')
          ->setPath($imgPath)
		 ->setResizeProportional(false)
          ->setWidth(363)
			->setHeight(560)
			->setOffsetX(570)  
			->setOffsetY(30); 
	
	// Add logo
    $slide->createDrawingShape()
          ->setName('timer Logo')
          ->setDescription('timer logo')
          ->setPath('../images/timer.gif')
		 ->setResizeProportional(false)
          ->setWidth(200)
			->setHeight(70)
			->setOffsetX(745)  
			->setOffsetY(625); 
	}
    // Return slide
    return $slide;
}


