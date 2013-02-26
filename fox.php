<?php
// http://mercenary-enclave.com/furcprojects.php
// http://www.furcadian.net/Palette/
error_reporting(E_ALL);
set_time_limit(10);
//define('DEBUG', );
isset($_GET['debug']) ? define('DEBUG', true) : define('DEBUG', false);
isset($_GET['dev']) ? define('DEV', true) : define('DEV', false);
include('GIFEncoder.class.php');
// seconds, minutes, hours, days
$expires = 60*60*24*1;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');

$file = __FILE__;
$last_modified_time = filemtime($file);
$etag = md5_file($file);
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT"); 
header("Etag: $etag");
/*if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time || 
		trim(@$_SERVER['HTTP_IF_NONE_MATCH']) == $etag) { 
	header("HTTP/1.1 304 Not Modified"); 
	exit; 
} //*/
class FOX {
	public $filename, $shapes;
	private $contents, $num_shapes, $port, $animPort;
	private $colors = array('c790ba', '800000', '008000', '808000', '000080', '800080', '008080', 'c0c0c0', 'c0dcc0', 'a6caf0', 'ff3737', 'e32727', 'c71717', 'ab0b0b', '8f0707', '630000', 'e7d3d7', 'd3a3af', 'bf7b87', 'ab5b67', '973b4b', '83232f', '730f1b', '5f000b', 'ab6f4f', 'a36b4f', '9b674f', '935f4f', '8f5f4f', '875b4b', '7f574b', '7b534b', 'ffe3cf', 'f7c39b', 'f3a36b', 'eb873f', 'd36f27', 'bb5b17', 'a34707', '8b3700', 'dbb7a3', 'd3ab93', 'cfa387', 'cb977b', 'c38f6f', 'bf8763', 'bb7f57', 'b7774f', 'fffbeb', 'fbebb7', 'f7df87', 'f3d75b', 'dbbb47', 'c79f33', 'af8727', '9b6f1b', 'af974f', '9f8b3f', '937f33', '877327', '776b1b', '6b5f13', '5f530b', '534b07', 'a3df83', '8fcb6b', '7bb753', '6ba33f', '5f8f2f', '4f7b1f', '436713', '37530b', '83c373', '6faf5b', '5f9b43', '4f8b2f', '3f771f', '336313', '2b530b', '274707', 'ebf3ff', 'b7cbe7', '8fabcf', '678bbb', '476fa3', '2b578f', '174377', '073363', 'e7ebff', 'dbdff7', 'c7cbe7', 'b3bbdb', 'a3abcf', '8f97bb', '7b83a7', '677397', 'fbd3ff', 'ebbbeb', 'd7a3cf', 'c38fb7', 'b37b9f', '9f6787', '8b576f', '7b475b', 'efe7f3', 'e7dbeb', 'cfbfd7', 'b7a3c3', 'a387af', '8f6f9b', '7b5b87', '674773', 'ebebff', 'cbc7ef', 'afabdf', '978fcf', '8773bf', '735faf', '67479f', '5b3793', 'ffffff', 'ebf3e7', 'dbe7d3', 'cbdbbf', 'bbcfab', 'abc39b', '9bb78b', '8faf7b', 'ffafc3', 'ef7f9f', 'e34f7f', 'd32767', 'c70753', 'ab0747', '8f0b3f', '6f072f', 'fffbaf', 'f3ef9f', 'e3e793', 'd3db87', 'c7cf7f', 'b7c373', 'a7b767', '9bab5f', 'f7e7e7', 'ebcfcf', 'dbbbbb', 'cfa7a7', 'c39797', 'b78787', 'ab7777', '9f6767', '935757', '874b4b', '7b3f3f', '6f3333', '632b2b', '571f1f', '4b1717', '3f1313', 'f3eff7', 'e3dbeb', 'd3c7df', 'c3b3d7', 'b3a3cb', 'a793c3', '9783b7', '8773ab', '7b67a3', '6f5b97', '634f8f', '534383', '473777', '3f2f6f', '332763', '2b1f5b', 'fffbdf', 'efebcb', 'e3dfbb', 'd7cfab', 'cbc39b', 'bfb38b', 'b3a77f', 'a79b73', '9b8f63', '8b7f57', '7f734b', '736743', '675b37', '5b4f2f', '4f4327', '43371f', 'f7f7f7', 'e7e3e3', 'dbd3d3', 'cbc3c3', 'bfb3b3', 'afa7a7', 'a39797', '938787', '877b7b', '776b6b', '6b5f5f', '5b4f4f', '4f4343', '3f3737', '332b2b', '171313', 'ffffff', 'f3efeb', 'e7dfdb', 'dbd3cf', 'cfc3bf', 'c3b7b3', 'b7aba7', 'ab9f9b', '9f938b', '93877f', '877b73', '7b6f67', '73675f', '675b53', '5b4f47', '53473f', 'ebd7f3', 'cfa7df', 'b77fcb', 'a35bb7', '933fa7', '7f2393', '6f0f7f', '5f006f', '8bbff3', '7793f7', '6763ff', '4b47e3', '2f2fc7', '1b1baf', '0b0b93', '00007b', 'ff5f1b', 'ffef07', '97d70b', '008747', '00878b', '135fff', 'fffbf0', 'a0a0a4', '808080', 'ff0000', '00ff00', 'ffff00', '0000ff', 'ff00ff', '00ffff', 'ffffff', );

	function debug()
	{
		if(DEBUG && isset($_GET['extra'])):
			define('DEBUG_EXTRA', true);
else:
		define('DEBUG_EXTRA', false);
		if(DEBUG) print("Add ?debug&extra to the end of the URL for extra debug information.\n");
		endif;
		//header("Content-Type: text/plain");
		//header("Content-Transfer-Encoding: binary");
		$this->filename = "nameless3.fox";
		#$this->filename = "ScalePort.fox";
		$handle = fopen($this->filename, "rb");
		$this->contents = fread($handle, filesize($this->filename));
		fclose($handle);
		$this->contents = substr($this->contents, 0, 4) === "FSHX" ? substr($this->contents, 4) : die("File is not a fox file");

		$fileVer = $this->unpack_int('i',0,4); // 0
		$this->num_shapes = $this->unpack_int('i',4,4); // 1
		$generator = $this->unpack_int('i',8,4); // 2
		$encryption = $this->unpack_int('i',12,4) == 0 ? 0 : die("Encryption detected, bailing out!"); // 3

		if(DEBUG) echo "Detected ".$this->num_shapes." shapes in $this->filename.\n";
		if(DEBUG) print_r(array(
					"0 Fox Version" => $fileVer,
					"1 Number of Shapes" => $this->num_shapes,
					"2 Generator" => $generator,
					"3 Encryption" => $encryption,
					));
		$this->getShapes();
	}

	function getShapes()
	{
		$shapeContents = substr($this->contents, 24);
		$shapes = array();
		for($s=1; $s<=$this->num_shapes; $s++)
		{
			$shapes[$s] = array();
			$frames = $this->unpack_int('S', 4, 2, $shapeContents);
			if($frames > 200) die("Too many frames! $frames");
			if(DEBUG) printf("\nflag: %d\n", $this->unpack_int('S', 0, 2, $shapeContents));
			$frameContents = substr($shapeContents, 8);
			$frameArray = array();
			if(DEBUG) printf("Detected %d frames in shape %d\n", $frames, $s);
			$shapes[$s] = array_merge($shapes[$s], array("frameCount" => $frames));
			$frameTotalSize = 0;
			for($i = 1; $i <= $frames; $i++)
			{
				//printf("format: %d\n", $this->unpack_int('S', 0, 2, $frameContents));
				$width = $this->unpack_int('S', 2, 2, $frameContents);
				$height = $this->unpack_int('S', 4, 2, $frameContents);
				$size = $this->unpack_int('L', 14, 4, $frameContents);
				if(DEBUG) printf("%d. Frame Width: %d Frame Height: %d Frame Size (In Bytes): %d\n", $i, $width, $height, $size);
				//array_push($frameArray, substr($frameContents, 18, $size));
				$frameArray[] = array(
						"img" => substr($frameContents, 18, $size),
						"width" => $width,
						"height" => $height,
						"size" => $size,
						);
				if(DEBUG_EXTRA && $frameArray[$i-1]['size'] < 10000): print("\nFrame Contents: "); print_r(unpack('C*', $frameArray[$i-1]['img'])); endif;
				$frameContents = substr($frameContents, 18+$size);
				$frameTotalSize = 18 + $size + $frameTotalSize;
			}
			$shapes[$s] = array_merge($shapes[$s], array(
						"frames" => $frameArray,
						));
			$size = 8 + $frameTotalSize;
			$ksLines = $this->unpack_int( 'S', 6, 2, $shapeContents );
			$ksContents = substr($shapeContents, $size, $ksLines * 6);
			$ksArray = array();

			if(DEBUG) printf("Lines of Kitterspeak: %d\n", $ksLines);

			for($k = 0; $k < $ksLines - 1; $k++)
			{
				$ksArray[] = array(
						"type" => $this->unpack_int('S', $k*6, 2, $ksContents),
						"value" => $this->unpack_int('S', $k*6+2, 2, $ksContents),
						"count" => $this->unpack_int('S', $k*6+4, 2, $ksContents),
						);
			}
			if(DEBUG)
				foreach($ksArray as $k => $v)
				{
					switch($v['type'])
					{
						case 1:
							$type = 'FRAME      ';
							break;
						case 2:
							$type = 'DELAY      ';
							break;
						case 3:
							$type = 'LOOP       ';
							break;
						case 4:
							$type = 'JUMP       ';
							break;
						case 5:
							$type = 'POSX       ';
							break;
						case 6:
							$type = 'POSY       ';
							break;
						case 7:
							$type = 'FURREX     ';
							break;
						case 8:
							$type = 'FURREY     ';
							break;
						case 9:
							$type = 'DRAW_FRONT ';
							break;
						case 10:
							$type = 'DRAW_BEHIND';
							break;
						case 11:
							$type = 'AUTO_FRAME_DELAY';
							break;
						case 12:
							$type = 'STOP       ';
							break;
						case 13:
							$type = 'CAMERA_STATE';
							break;
						default:
							$type = "UNKNOWN (".$v['type'].")";
							break;
					}
					printf("%02d. This step sets the %s with a value of %d and runs %d times.\n", $k, $type, $v['value'], $v['count']);
				}


			//printf("flag2: %d\n", $this->unpack_int('S', 6, 2, $shapeContents));
			$size = 8 + $frameTotalSize + ( $ksLines * 6 );
			$shapeContents = substr($shapeContents, $size);
		}
		$this->shapes = $shapes;
	}

	function generatePort($image, $mode = 1)
	{
		$width=95;
		$height=95;
		$gd = imagecreatetruecolor(95,95);
		imagealphablending($gd, false);
		imagesavealpha($gd, true);
		//die(imagecolorallocatealpha($gd, 0, 0, 0, 0xff));
		//imagefill($gd, 0, 0, imagecolorallocatealpha($gd, 0, 0, 0, 0xff));
		imagefill($gd, 0, 0, 0xffffffff);
		imagecopy($gd, $this->generateImg($image, true), 0, 0, 0, 0, $image['width'], $image['height']);

		//header('Content-Type: image/png');
		//imagepng($gd);
		if($mode === 0)
			return $gd;
		if($mode === 1)
			$this->port = $gd;
		if($mode === 2):
			header('Content-Type: image/png');imagepng($gd); imagedestroy($gd); endif;

	}

	function generateImg($image, $remap = false, $mode = 0)
	{
		$width = $image['width'];
		$height = $image['height'];
		$gd = imagecreatetruecolor($width,$height);
		imagealphablending($gd, true);
		imagefill($gd, 0, 0, 0xffffffff);
		$colors = $this->getPalette();
		if($remap)
			$this->remapColors($colors, 't###1@?@?>?%%$'); //*/
			/*$this->remapColors($colors, 't85M1@?@?>?%%$'); //*/
		$wh = $width*$height;
		for($i = 1; $i <= $wh; $i++)
		{
			$color = null;
			$c = $this->unpack_int('C', $wh - $i, 1, $image['img']);
			if($c <= 255 && $c != 0)
			{

				$color = $colors[$c];
			}
			$color = isset($color) ? $color : 0xff000000; 
			imagesetpixel($gd, ($wh - $i)%$width,$i/$width, $color);
		}
		//$gd = imagerotate($gd, 180, 0);

		//header('Content-Type: image/png');
		//imagepng($gd);
		//$mode = 2;
		if($mode === 0)
			return $gd;
		if($mode === 1)
			$this->port = $gd;
		if($mode === 2):
			header('Content-Type: image/png');imagepng($gd); endif;

	}

	function generateAnimPort($image)
	{
		//$port = isset($this->port) ? array($this->port) : array();
		$framei = array();
		$framed = array();
		foreach($image["frames"] as $frame)
		{
			ob_start();
			imagegif($this->generatePort($frame, 0));
			$framei[] = ob_get_contents();
			$framed[] = 40;
			ob_end_clean();
		}
		header ('Content-type:image/gif');
		$gif = new GIFEncoder($framei,$framed,0,2,0,0,0,'bin');
		echo $gif->GetAnimation();
	}

	function remapColors(&$colors, $code)
	{
		global $colorMap;
		if(false)
		for($i = 1; $i <= 255; $i++)
			if(
					$i == 11 ||
					( $i >= 16 && $i <= 23 ) ||
					( $i >= 32 && $i <= 39 ) ||
					$i == 50 ||
					( $i >= 72 && $i <= 79 ) ||
					( $i >= 80 && $i <= 87 ) ||
					( $i >= 128 && $i <= 135 ) ||
					( $i >= 136 && $i <= 143 ) ||
					( $i >= 199 && $i <= 206 ) ||
					( $i >= 224 && $i <= 231 )// || ($i!=207 && $i!=158 && $i!=191 && $i!=52 && $i!=49)
				)
				$colors[$i] = 0xFFFFFF;
		if($code[0] === 't')
		{
			if(DEBUG):
			echo "$code\n";
			for($i = 1; $i <= 10; $i++)
			{
			echo "$i. ";
			echo unpack('C', $code[$i])[1] . "\n";
			}
			echo "\n";
			endif;
			$code[1] === '#' ? $colors[200] = 0x5b4f4f : null;
			$code[2] === '#' ? $colors[141] = 0x5b4f4f : null;
			$code[3] === '#' ? $colors[131] = 0x3f1313 : null;
		}
	}

	function unpack_int($type, $start, $stop, $string = null)
	{
		$string = is_null($string) ? $this->contents : $string;
		return unpack($type, substr($string, $start, $stop))[1];
	}

	function getPalette() {
		$arr = array();
		if ($fh = fopen('marbled.pcx', 'rb')) {
			fseek($fh, -768, SEEK_END);
			while (!feof($fh))
			{
				$tmp = fread($fh, 1);
				if(!feof($fh))
					$arr[] = unpack('C', $tmp)[1];
			}
			fclose($fh);
		}
		$tmpArr = array();
		for($i=0;$i<sizeof($arr)/3;$i++)
		{
			$tmpArr[] = ($arr[$i*3] << 0x10) + ($arr[$i*3+1] << 0x8) + $arr[$i*3+2];
		}
		return $tmpArr;
	}
	function pc()
	{
	print_r($this->colors);
	}
}



$foxy = new FOX();
$foxy->debug();
if(isset($_GET['1'])):
	$foxy->generatePort($foxy->shapes[1]['frames'][0], 2);
	exit;
endif;
if(isset($_GET['2'])):
	$foxy->generatePort($foxy->shapes[1]['frames'][1], 2);
	exit;
endif;
if(isset($_GET['3'])):
	$foxy->generatePort($foxy->shapes[1]['frames'][2], 2);
	exit;
endif;
if(DEBUG || DEV): echo '<pre>'; endif;
if(DEV) var_dump($foxy->getPalette());

//print_r(array_keys($foxy->shapes[1]['frames']));
if(!DEBUG && !DEV) $foxy->generatePort($foxy->shapes[1]['frames'][0], 2);
//if(!DEBUG && !DEV) $foxy->generatePort($foxy->shapes[1]['frames'][0], 2);
//if(!DEBUG && !DEV) $foxy->generateImg($foxy->shapes[1]['frames'][0]);
//if(!DEBUG && !DEV) $foxy->generateAnimPort($foxy->shapes[1]);
if(DEBUG && !DEV) $col = $foxy->getPalette();
//if(DEBUG && !DEV) $foxy->pc();
if(DEBUG && !DEV) $foxy->remapColors($col, 't85M1@?@?>?%%$'); //*/
if(DEBUG && !DEV) $foxy->remapColors($col, 't##########%&$'); //*/
if(DEBUG || DEV): echo '</pre>'; endif;
// vim: ts=2 sw=2 ff=dos ai: