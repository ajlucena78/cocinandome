<?php 
	###########################################################################################
	#
	#  CAPTCHA FáCIL 1.0
	#
	#  Autor: Alejandro Martín Nez
	#  Contact: alemnunez at gmail dot com
	#  Date: October 10, 2009
	#
	#  COMO USAR CAPTCHA FCIL
	#
	#  FORMULARIO
	#  En el formulario que deseas validar, inserta el siguiente cdigo:
	#  
	#  <img src="captcha.php" /><br/>
	#  <input type="text" size="12" name="captcha" />
	#
	#
	#  VERIFICACIN
	#  Al procesar el formulario, compara el contenido del campo que 
	#  complet el usuario con el contenido de $_SESSION["captcha"] 
	#  que gener este programa:
	#
	#  session_start();
	#  if(strtoupper($_REQUEST["captcha"]) == $_SESSION["captcha"]){
	#	 // REMPLAZO EL CAPTCHA USADO POR UN TEXTO LARGO PARA EVITAR QUE SE VUELVA A INTENTAR
	#	 $_SESSION["captcha"] = md5(rand()*time());
	# 	 // INSERTA EL CDIGO EXITOSO AQUI
	#  }else{
	#	 // REMPLAZO EL CAPTCHA USADO POR UN TEXTO LARGO PARA EVITAR QUE SE VUELVA A INTENTAR
	#	 $_SESSION["captcha"] = md5(rand()*time());
	# 	 // INSERTA EL CDIGO DE ERROR AQU
	#  }
	#
	#  
	#  OLVID EL SPAM!
	#
	###########################################################################################
	
	#create image and set background color
	//$captcha = imagecreatetruecolor(120, 35);
	$captcha = imagecreatetruecolor(240, 70);
	//$color = rand(128, 160);
	$color = 255;
	$background_color = imagecolorallocate($captcha, $color, $color, $color);
	imagefill($captcha, 0, 0, $background_color);
	
	#draw some lines
	for($i = 0; $i < 15; $i++){
		$color = rand(48,96);
		//imageline($captcha, rand(0,130),rand(0,35), rand(0,130), rand(0,35)
				//,imagecolorallocate($captcha, $color, $color, $color));
		imageline($captcha, rand(0, 260),rand(0, 70), rand(0, 260), rand(0, 70)
				, imagecolorallocate($captcha, $color, $color, $color));
	}
	
	#generate a random string of 5 characters
	$string = substr(md5(rand()*time()), 0, 5);

	#make string uppercase and replace "O" and "0" to avoid mistakes
	$string = strtoupper($string);
	$string = str_replace("O","B", $string);
	$string = str_replace("0","C", $string);

	#save string in session "captcha" key
	session_start();
	$_SESSION["captcha"] = $string;

	#place each character in a random position
	$font = 'arial.ttf';
	for($i=0;$i<5;$i++){
		$color = rand(0,32);
		if(file_exists($font)){
			//$x=4+$i*23+rand(0,6);
			$x = 8 + $i * 46 + rand(0, 12);
			//$y=rand(18,28);
			$y = rand(36, 56);
			//imagettftext  ($captcha, 15, rand(-25, 25), $x, $y, imagecolorallocate($captcha, $color, $color
					//, $color), $font, $string[$i]);
			imagettftext  ($captcha, 30, rand(-50, 50), $x, $y, imagecolorallocate($captcha, $color, $color
					, $color), $font, $string[$i]);
		}else{
			//$x=5+$i*24+rand(0,6);
			$x = 10 + $i * 48 + rand(0, 12);
			//$y=rand(1,18);
			$y = rand(2, 36);
			//imagestring($captcha, 5, $x, $y, $string[$i], imagecolorallocate($captcha, $color, $color, $color));
			imagestring($captcha, 10, $x, $y, $string[$i], imagecolorallocate($captcha, $color, $color, $color));
		}
	}
	
	#applies distorsion to image
	$matrix = array(array(1, 1, 1), array(1.0, 7, 1.0), array(1, 1, 1));
	imageconvolution($captcha, $matrix, 16, 32);

	#avoids catching
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); 

	#return the image
	header("Content-type: image/gif");
	imagejpeg($captcha);