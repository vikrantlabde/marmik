<?php
    /**
  * 
  * This file contents image verfication code. 
  * 
  * @author Praxis Solutions 
  * 
  */
	if (!function_exists('file_put_contents')) {
        function file_put_contents($filename, $content) {
            if (!($file = fopen($filename, 'w'))) {
                return false;
            }
            $n = fwrite($file, $content);
            fclose($file);
            return $n ? $n : false;
        }
    }

    // Start PHP session support
    session_start();

    $ok = 0;

    if (isset($_POST['phrase']) &&  isset($_SESSION['phrase'])) 
    {
    	if(($_POST['phrase'] == $_SESSION['phrase']))
    	{
	        $boolIsImageVarified = 1;     
	        $ok = 1;
	        unset($_SESSION['phrase']);
     	}
    } 
    else 
    {
        $boolIsImageVarified = 0;
    }
  
   
    @unlink('images/captcha/'.md5(session_id()) . '.png');


    if (!$ok) {
    	
        require_once 'Text/CAPTCHA.php';

        // Set CAPTCHA image options (font must exist!)
        $imageOptions = array(
            'font_size'        => 18,
            'font_path'        => PROJECT_LIB.'/font',
            'font_file'        => 'Vera.ttf',
            'text_color'       => '#000000',
            'lines_color'      => '#000000',
            'background_color' => '#F7F7F7'
        );

        // Set CAPTCHA options
        $options = array(
            'width' => 150,
            'height' => 50,
            'output' => 'png',
            'imageOptions' => $imageOptions
        );
                   
        // Generate a new Text_CAPTCHA object, Image driver
        $c = Text_CAPTCHA::factory('Image');
        $retval = $c->init($options);
        if (PEAR::isError($retval)) {
            printf('Error initializing CAPTCHA: %s!',
                $retval->getMessage());
            exit;
        }
    
        // Get CAPTCHA secret passphrase
        $_SESSION['phrase'] = $c->getPhrase();
    	
        // Get CAPTCHA image (as PNG)
        $png = $c->getCAPTCHA();
        if (PEAR::isError($png)) {
            printf('Error generating CAPTCHA: %s!',
                $png->getMessage());
            exit;
        }

        file_put_contents('images/captcha/'.md5(session_id()) . '.png', $png);
          
		$strHtml = "<table width='50%' border='0' style='border:dotted #666666 1px'>
					  <tr>
					    <td><strong>Security Check:</strong> Enter the word below. <a href='#'>What is this?</a> </td>
					  </tr>
					  <tr>
					    <td>Cant read this? <a href=\"javascript:fnAjaxCaller('idvarifyimage','userbasicinfo','image', '&id=', ' ', '');void(0);\">Try another.</a> </td>
					  </tr>
					  <tr>
					    <td align='center' height='65' >
							<table><tr><td style='border:solid #f7f7f7 1px'>
							<div id='idvarifyimage'><img src='images/captcha/".md5(session_id()) . ".png?".time()."'  /><div>
							</td><tr></table>
		
							</td>
					  </tr>
					  <tr>
					    <td align='center' height='25'>Text in the box: <input type='text' name='phrase' id='id_seccheck' class='input' /></td>
					  </tr>
					</table>";
		
		
		   #-----------------------------------#
		   if($_GET['ajax_action'] == 'image')
		   {
		      include_once(DOCUMENT_ROOT."/util/clsAjaxUtil.php");   	  	
		      print "<img src='images/captcha/".md5(session_id()) . ".png?".time()."'  />";
		      exit; 
		   }			   
			   
			
			
    }

?>