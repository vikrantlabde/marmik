<?php
/**
 * This this common function file
 * @author Vikrant Labde <vikrant.labde@gmail.com>
 *
 */
class clsUtil
{
	/**
	* function fnMarmik execute any function located in any module and class
	*
	* @param string $strModule
	* @param string $strClass
	* @param string $strFunction
	* @param array $arrParams
	* @global array $_ARRDSN
	*
	* @return mixed value
	*
	*/
	function fnMarmik($strModule,$strFunction,$arrParams=array(),$hdlPluginDbObj=0)
	{
		$hdlPassDb = (!$hdlPluginDbObj)?$this->hdlDb:$hdlPluginDbObj;
		$strModuleClass = "cls".ucfirst($strModule);
		if(is_file(DOCUMENT_ROOT."/modules/$strModule/$strModuleClass.php"))
		{
			require_once DOCUMENT_ROOT."/modules/$strModule/$strModuleClass.php";
			$hdlMarmik = new $strModuleClass($hdlPassDb,$strModule);
			
			if(is_array($arrParams))
			{
				$intParamCount = count($arrParams);
				list($varParam,$varParam1,$varParam2,$varParam3,$varParam4,$varParam5,$varParam6,$varParam7,$varParam8,$varParam9) = $arrParams;
				
				switch ($intParamCount)
				{

					case 0:
						$varOutput = $hdlMarmik->$strFunction();
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 1:
						$varOutput = $hdlMarmik->$strFunction($varParam);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 2:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 3:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 4:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 5:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3,$varParam4);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 6:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3,$varParam4,$varParam5);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 7:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3,$varParam4,$varParam5,$varParam6);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 8:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3,$varParam4,$varParam5,$varParam6,$varParam7);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 9:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3,$varParam4,$varParam5,$varParam6,$varParam7,$varParam8);
						unset($hdlMarmik);
						return $varOutput;
					break;
					case 10:
						$varOutput = $hdlMarmik->$strFunction($varParam,$varParam1,$varParam2,$varParam3,$varParam4,$varParam5,$varParam6,$varParam7,$varParam8,$varParam9);
						unset($hdlMarmik);
						return $varOutput;
					break;
				}
			}
		}
	}
		/**
	    * Function fnProcessStructure to process the page content
	    * @param array $arrContent
	    * @return object

	    */
		function fnProcessStructure($arrContent)
		{
			$strThemeName = clsUtil::fnGetTheme(); //GET THE THEME NAME
			$strFileName = $this->GLOBALTPL;
			$hdlDb =$this->hdlDb;
			
			$hdlTpl = &new HTML_Template_Sigma( DOCUMENT_ROOT."/themes/$strThemeName" );
			
			$hdlTpl->loadTemplateFile("$strFileName.tpl.html",1,1);
			
			#GET LEFT PANEL
			clsUtil::fnGetLeftPanel($hdlTpl);

			#GET RIGHT PANEL
			clsUtil::fnGetRightPanel($hdlTpl);
	
			$hdlTpl->setVariable("TITLE", trim($this->WINDOW_TITLE));
			$hdlTpl->setVariable("META_DESC", trim($this->METADESCRIPTION));
			$hdlTpl->setVariable("META_KEYWORDS", trim($this->META_KEYWORDS));
			$hdlTpl->setVariable("BASE_HREF",BASE_HREF."/themes/$strThemeName/");			
			$hdlTpl->setVariable("DOMAIN",SITE_NAME);
			$hdlTpl->setVariable($arrContent);			
			$hdlTpl->setVariable("GOOGLE_ANALYTICS",GOOGLE_ANALYTICS);
			
			return $hdlTpl->get();
		}


	function fnGetSession()
	{
	
	
	}
		
	/**
	* Function fnGetLeftPanel gets the left panel object.Parse Left Panel Called in clsUtil::fnProcessStructure()
	* @param object Template
	*/
	function fnGetLeftPanel($hdlTpl)
	{
		if(!$this->LEFT_PANEL)
		{
			$hdlTpl->hideBlock("LEFT_COLUMN");
		}
		else
		{
			if(!$this->IS_DEFAULT_LEFT)
			{
				if($this->GET_LEFT_FROM_OTH_MODULE == "")
				{
					$this->fnProcessLeft($hdlTpl);
				}
				else
				{

					// CALLING PANELS FROM DIFFERENT MODULES
					$strModuleClass = "cls".ucfirst($this->GET_LEFT_FROM_OTH_MODULE);

					if(is_file(DOCUMENT_ROOT."/modules/".$this->GET_LEFT_FROM_OTH_MODULE."/$strModuleClass.php"))
					{
						require_once DOCUMENT_ROOT."/modules/".$this->GET_LEFT_FROM_OTH_MODULE."/$strModuleClass.php";

						$strAction = $this->strAction;
						$hdlMarmik = new $strModuleClass($this->hdlDb,$this->GET_LEFT_FROM_OTH_MODULE,$this->strAction);
						$hdlMarmik->G = $this->G;
						$hdlMarmik->fnProcessLeft($hdlTpl);
					}
				}
			}
			else
			{
				clsUtil::fnProcessDefaultLeftPanel($hdlTpl);
			}
		}
	}

	 /**
	  * Function fnProcessDefaultLeftPanel process default left panel.If there's default leftpanel sitewide.
	  * @param object $hdlTpl
	  */
	  function fnProcessDefaultLeftPanel($hdlTpl)
	  {
	  		 //
	  }

	/**
	* Function fnGetRightPanel gets right panel object.Parse right Panel Called in clsUtil::fnProcessStructure()
	* @param object $hdlTpl
	*/
	function fnGetRightPanel($hdlTpl)
	{
		if(!$this->RIGHT_PANEL)
		{
			$hdlTpl->hideBlock("RIGHT_COLUMN");
		}
		else
		{
			if(!$this->IS_DEFAULT_RIGHT)
			{
				if($this->GET_RIGHT_FROM_OTH_MODULE == "")
				{
					$this->fnProcessRight($hdlTpl);
				}
				else
				{
					// CALLING PANELS FROM DIFFERENT MODULES
					$strModuleClass = "cls".ucfirst($this->GET_RIGHT_FROM_OTH_MODULE);
					if(is_file(DOCUMENT_ROOT."/modules/".$this->GET_RIGHT_FROM_OTH_MODULE."/$strModuleClass.php"))
					{
						require_once DOCUMENT_ROOT."/modules/".$this->GET_RIGHT_FROM_OTH_MODULE."/$strModuleClass.php";
						$hdlMarmik =   new $strModuleClass($this->hdlDb,$this->GET_RIGHT_FROM_OTH_MODULE,$this->strAction);
						$hdlMarmik->fnProcessRight($hdlTpl);
					}
				}
			}
			else
			{
				clsUtil::fnProcessDefaultRightPanel($hdlTpl);
			}
		}
	}

	/**
	* Function fnProcessDefaultRightPanel process default right panel.If there's default right panel sitewide
	* @param object $hdlTpl
	*/
	function fnProcessDefaultRightPanel($hdlTpl)
	{
	}

	/**
	* Function fnGetTheme identifies the theme and return the folder name of the theme
	* @return string themename
	*/
	function fnGetTheme()
	{
		return $this->THEME;
	}
	
	/**
	* Function fnTemplateClass creates Object of Template Class
	* we are using PEAR HTML_TEMPLATE_SIGMA for templating system
	*
	* @param Oject Module
	* @return Object
	*/
	function fnTemplateClass($strModule)
	{
		$hdlTpl = &new HTML_Template_Sigma( DOCUMENT_ROOT."/modules/$strModule/tpl" );
		return $hdlTpl;
	}

	/**
	* Function fnGetJsSrcString returns the JavaScript code
	*
	* @param string $strJsFileName
	* @return string
	*/
	function fnGetJsSrcString($strJsFileName,$boolFromGlobal=false,$strModuleName="")
	{
		if($boolFromGlobal)
		{
			$strJsSrcPath = SITE_NAME."/js/$strJsFileName.js";
			$strJsFile = "<script language='javascript' src='$strJsSrcPath'></script>";
			return $strJsFile;
		}
		else
		{
			if($strModuleName=="")
			{
				$strJsSrcPath = SITE_NAME."/modules/".$this->strModule."/js/$strJsFileName.js";
				$strJsFile = "<script language='javascript' src='$strJsSrcPath'></script>";
			}
			else 
			{
				$strJsSrcPath = SITE_NAME."/modules/$strModuleName/js/$strJsFileName.js";
				$strJsFile = "<script language='javascript' src='$strJsSrcPath'></script>";
			}
			return $strJsFile;
		}
	}

	/**
	* Function fnRedirect redirects to specific location
	* @param string $strUrl,
	* @param string $strMethod
	* @return void
	* @desc This function redirects the page to the passed URL
	*/
	function fnRedirect($strUrl, $strMethod = '')
	{
		# Redirect page to the URL in strUrl.
		header("location: ". $strUrl);
		exit();
	}

	/**
	 * Function fnGETParams filters the get input
	 * @return array
	 */
	  function fnGETParams()
	  {
	  		$arrGET = array();
	  		if (count($_GET) > 0 && is_array($_GET))
	  		{
		  		foreach($_GET as $strVar => $varVal)
				{
					if($strVar == 'action') continue;
					$arrGET[trim($strVar)] = $varVal;
				}
	  		}
			return $arrGET;
 	  }

 	  /**
 	   * Function fnPOSTParams filters the post input
 	   * @return array
 	   */
	  function fnPOSTParams()
	  {
	  	$arrPOST = array();
	  	if (count($_POST) > 0 && is_array($_POST))
	  	{
		  	foreach($_POST as $strVar => $varVal)
	  		{
	  			$arrPOST[trim($strVar)] = $varVal;
	  		}
	  	}
	    return $arrPOST;
	  }

	   /**
 	   * Function fnREQUESTParams to filter the request input
 	   * @return array
 	   */
	  function fnREQUESTParams()
	  {
	  	$arrREQUEST = array();
	  	if (count($_REQUEST) > 0 && is_array($_REQUEST))
	  	{
		  	foreach($_REQUEST as $strVar => $varVal)
	  		{
	  			$arrREQUEST[trim($strVar)] = $varVal;
	  		}
	  	}

		return $arrREQUEST;
	  }

	  /**
 	   * Function fnSESSIONParams filters the post input
	   * @param string
 	   * @return var
 	   */
	  function SESSION($strValue)
	  {
	  	if(isset($_SESSION[$strValue]))
		{
			return $_SESSION[$strValue];
		}
		return false;
	  }	
		
	  /**
	   * Function fnBuildUrl builds SEF URL Format
	   *
	   * @param string $strAction
	   * @param string $strParams
	   * @param string $strFakePath
   	   * @param string $strRewriteUrl
	   * @return string formated Url
	   */
	  function fnBuildUrl($strAction, $strParams = "", $strFakePath = "" ,$strRewriteUrl = "",$strSiteId="")
	  {	  
			
		if($strSiteId)
		{
			switch($strSiteId)   
			{
				case "jm" :
						$strSiteName=JMSITENAME;
				break;
			}
			
		}

	   	 if(SIMPLE_URL)
  		 {
			if(!$strSiteId)
			{
  		 		$strUrl = SITE_NAME."/index.php?action=$strAction";
  				if(trim($strParams) != "")
  				$strUrl .= "&$strParams";
			}
			else
			{
				$strUrl = $strSiteName."/index.php?action=$strAction";
  				if(trim($strParams) != "")
  				$strUrl .= "&$strParams";

			}
  		 }
  		 else
  		 {

		 	if($strRewriteUrl != "")
		 	{
				if(!$strSiteId)
				{
		 		  $strUrl = SITE_NAME."/$strRewriteUrl";
				}
				else
				{
					$strUrl = $strSiteName."/$strRewriteUrl";
				}
		 	}
		 	else
		  	{
  		 		if($strFakePath != "")
  		 		{
					if(!$strSiteId)
					{
  			 			$strUrl = SITE_NAME."/$strFakePath/$strAction";
					}
					else
					{
						$strUrl = $strSiteName."/$strFakePath/$strAction";
					}
				
  		 		}
  		 		else
  		 		{
					if(!$strSiteId)
					{
  		 				$strUrl = SITE_NAME."/$strAction";
					}
					else
					{
						$strUrl = $strSiteName."/$strAction";
					}
  		 		}

				if(trim($strParams) != "") $strUrl .= "?$strParams";
		  	}
  		 }
		
		 return $strUrl;
	  }

	/**
 	   * Function fnTransformUrl to recognise links in text
   	   * @param string $strText
	   * @param Object Database Handler
 	   * @return string
 	   */

	function fnConverturlIntoBitLy($text,$hdlDb="",$strIsMediaComment="")
	{  
	 	$text = str_replace("<br>", " <br>", $text);
		$text = str_replace("<br/>", " <br/> ", $text);
		$text = str_replace("<br />", " <br /> ", $text);
	
		preg_match_all("|([https\|http])+://(([.]?[\S])*)|", $text, $arrOut, PREG_SET_ORDER);
		
			
		$strNewText = "";
		if(is_array($arrOut))
		{
			if(count($arrOut))
			{
				foreach($arrOut as $intKey=>$arrLinks)
				{
					$strOriginalLink = $arrLinks[0];
					
						if(!strstr($strOriginalLink,"http://bit.ly") && strlen($strOriginalLink) > 50)
						{ 
							$strConvertedLink =  clsUtil::fnCreateShortUrl($strOriginalLink);
							if(!$strConvertedLink)
							{
								$strConvertedLink = $strOriginalLink;
							}
						}
						else 
						{
							$strConvertedLink = $strOriginalLink;
						}
					
						//$strConvertedLink = '<a href="'.$strConvertedLink.'" target="_blank">'.$strConvertedLink.'</a>';

					$strNewText = str_replace($strOriginalLink, $strConvertedLink, $text);
					$text = $strNewText;
				}
			}
		}
	
		if(trim($strNewText) == "") $strNewText = $text;
		return $strNewText;			
	}


	 /**
 	   * Function fnGetDateTimeDuration returns the string that contain information for the time and date duration of any post
   	   * @param string $strActualDateTime
 	   * @return string
 	   */

    function fnGetDateTimeDuration($strActualDateTime, $strDateFormat="")
	{
		/*
			About 1 second ago  ?1 second
			A few seconds ago 	>1 second
			About a minute ago 	?30 seconds
			[x] minutes ago 	?1 minute, 30 seconds
			[full time] 	>59 minutes
			Today 	>1 hour, 30 minutes
			Yesterday 	>today's date
			[full date] 	>yesterday's date
		*/

		if(!$strActualDateTime)
		{
			return ;
		}

		$dateTempToday=clsDbUtil::fnSelectOne("SELECT NOW()",__FILE__,__FUNCTION__,__LINE__);

		$strDateDiff = strtotime($dateTempToday) - strtotime($strActualDateTime);
	
		if($strDateDiff>172800) // before yesterday
        {
			if ($strDateFormat == "")
	        	$strTempVal = date("j F Y",strtotime($strActualDateTime));
			else
	        	$strTempVal = date($strDateFormat,strtotime($strActualDateTime));
        }
        elseif($strDateDiff>86400) // before day
        {
        	//$strTempVal = round($strDateDiff/86400,0).' day';
			if ($strDateFormat == "")
        		$strTempVal = date("j F Y",strtotime($strActualDateTime));
			else
	        	$strTempVal = date($strDateFormat,strtotime($strActualDateTime));
        }
		// by prachi
		elseif(($strDateDiff>3600) && ($strDateDiff<21600))  // between 1 to 6 hrs
        {
        	$strTempVal = 'About '.round($strDateDiff/3600,0).' hours ago';
        }
		elseif($strDateDiff>=21600) // before 6 hr
        {	//echo $strDateDiff."<br>";
		   //echo round($strDateDiff/60,0);	die;
        	$strTempVal = 'Today';
        }

	    elseif($strDateDiff>3600) // before hr
        {
        	$strTempVal = round($strDateDiff/3600,0).' hour';
        }
        elseif($strDateDiff>=90) // before min and 30 sec
        {
        	$strTempVal = round($strDateDiff/60,0).' minutes ago';
        }
	    elseif($strDateDiff>=30) // before 30 sec
        {
        	$strTempVal = 'About a minute ago';
        }
        elseif($strDateDiff > 1) // before 1 sec
        {
        	$strTempVal = 'A few seconds ago';
        }
        elseif($strDateDiff<=1) // less then sec
        {
        	$strTempVal = 'About 1 second ago';
        	//$strTempVal = 'A few seconds ago';
        }

        return $strTempVal;
	}


	
	    /**
	   * Function fnGetPagerData is pagination function
	   *
	   * @param int $intTotal
	   * @param int $intLimit
	   * @param string $strParams
	   * @param bool $isFirstLast
	   * @param string $strTempAction
	   * @param string $strAnchorParam for anchor tag
   	   * @return object $hdlReturn
	   */

	    function fnGetPagerData($intTotal, $intLimit, $strParams="", $isFirstLast = 1,$strTempAction="",$strAnchorParam="", $strGetPageParam = "page",$strUseImages="")
	    { 
			$intPage = $_GET[$strGetPageParam];

			   if($strTempAction == "")
		       {
		       		$strPageLink = clsUtil::fnBuildUrl($this->strAction, $strParams);
		       }
		       else
		       {
		       		$strPageLink = clsUtil::fnBuildUrl($strTempAction, $strParams);
		       }

		  	   if(!$intPage)
		  	   {
		  		 $intPage = 1;
		  	   }

	           $intTotal  = (int) $intTotal;
	           $intLimit    = max((int) $intLimit, 1);
	           $intNumPages = ceil($intTotal / $intLimit);			   

	           $intPage = max($intPage, 1);
	           $intPage = min($intPage, $intNumPages);
			   	   
	           $intOffset = ($intPage - 1) * $intLimit;
			   
			   $isLessFlag = 0;
	           /* TEMPARORY CLASS FOR OBJECT FORWARDING */

	           if($isFirstLast == 1)
	           {
	           		$strFnLinkCls = "fnlink";
	           		$strCPageCls = "cpage";
	           		$strCOnPageCls = "conpage";
	           }
	           else
	           {
	           		$strFnLinkCls = "";
	           		$strCPageCls = "active";
	           		$strCOnPageCls = "";
	           }

	            if ($intPage <= 1) // this is the first page - there is no previous page
				    //$strTempPrevPage = " <a href='javascript:void(0);' class='fnlink'>Previous</a> | ";
				    $strTempPrevPage = " ";
				else
				{            // not the first page, link to the previous page
					if($strUseImages==1)
						$strTempPrevPage = "<a href=\"$strPageLink&$strGetPageParam=" . ($intPage - 1) ."$strAnchorParam". "\" class='$strFnLinkCls'><img src=\"images/mdc/ico_prev.gif\"/></a>  ";
					else
						$strTempPrevPage = "<a href=\"$strPageLink&$strGetPageParam=" . ($intPage - 1) ."$strAnchorParam". "\" class='$strFnLinkCls'>Previous</a> | ";
				}	
		
				if ($intPage == $intNumPages) // this is the last page - there is no next page
				   $strTempNextPage = " ";
				else  
				{          // not the last page, link to the next page
					if($strUseImages==1)
						$strTempNextPage = "  <a href=\"$strPageLink&$strGetPageParam=" . ($intPage + 1) ."$strAnchorParam". "\" class='$strFnLinkCls'><img src=\"images/mdc/ico_next.gif\"/></a> ";
					else
						$strTempNextPage = " | <a href=\"$strPageLink&$strGetPageParam=" . ($intPage + 1) ."$strAnchorParam". "\" class='$strFnLinkCls'>Next</a> ";
				}	
				

	       	    if ($intPage <= 1) // this is the first page - there is no previous page
				   $strPrevPage = " ";
				else
				{
					 if($isFirstLast == 1)
	           		{          // not the first page, link to the previous page
	           			$strPrevPage = "<a href=\"$strPageLink&$strGetPageParam=1".$strAnchorParam." \" class='$strFnLinkCls'>First</a> | $strTempPrevPage";
		        		}
	           		else
	           		{
	           			$strPrevPage = " $strTempPrevPage";
	           		}
				}

				######### Current Pages #########

					//$strCurrPage =  " Page ".$intPage ." of ".$intNumPages;
				if ($intPage >= 1 && $intPage <= 5)
				{
					$intPreCnt = 1;
					$isLessFlag = 1;
				}
				else
				{
					//$intTempPre = $intPage / 2;
					$intPreCnt = $intPage - 5;
				}

				if ($intPage >= ($intNumPages-4) && $intPage <= $intNumPages)
				{
						$intPostCnt = $intNumPages;

						if($intPage == $intNumPages && $isLessFlag == 0)
							$intPreCnt = $intPage - 9;
						elseif($intPage >= ($intNumPages-4) && $intPage < $intNumPages && $isLessFlag == 0)
							$intPreCnt = $intNumPages - 9;
				}
				else
				{
					if($intPage == 1)
						$intPostCnt = $intPage + 9;
					elseif($intPage > 1 && $intPage <= 5)
						$intPostCnt = $intPage + (10-$intPage);
					else
						$intPostCnt = $intPage + 4;
				}

				if($intPostCnt > $intNumPages)
				{
					$intPostCnt = $intNumPages;
				}

				for ($intTempCnt=$intPreCnt; $intTempCnt<=$intPostCnt; $intTempCnt++)
				{
					if($intTempCnt > 0)
					{
						if($intTempCnt == $intPage)
						 	$strCurrPage .= "<a href='javascript:void(0);' class='$strCPageCls'>$intTempCnt</a> ";
						else
							$strCurrPage .= "<a href=\"$strPageLink&$strGetPageParam=" . $intTempCnt .$strAnchorParam. "\" class='$strCOnPageCls'>$intTempCnt</a> ";
							//$strCurrPage .= "<a href=\"index.php?$strParams&$strGetPageParam=" . $intTempCnt . "\" class='$strCOnPageCls'>$intTempCnt</a> ";
					}
				}
				######### Current Pages #########

					if ($intPage == $intNumPages) // this is the last page - there is no next page
					    //$strNextPage = " $strTempNextPage | <a href='javascript:void(0);' class='fnlink'>Last</a>";
					    $strNextPage = " ";
					else
					{        // not the last page, link to the next page
						if($isFirstLast == 1)
		           		{
						    $strNextPage = " $strTempNextPage | <a href=\"$strPageLink&$strGetPageParam=" . $intNumPages .$strAnchorParam. "\" class='$strFnLinkCls'>Last</a>";
						    //$strNextPage = " $strTempNextPage | <a href=\"index.php?$strParams&$strGetPageParam=" . $intNumPages . "\" class='$strFnLinkCls'>Last</a>";
		           		}
		           		else
		           		{
		           			$strNextPage = " $strTempNextPage";
		           		}
					}

				 // use pager values to fetch data
		  		if($intOffset < 0)
			  	{
			  		$intOffset = 0;
			  	}
		  	    /*-------------------*/

		  	    //print $intOffset." ".$intLimit;
		  	    $hdlReturn = new stdClass;
		  	    $hdlReturn->intOffset = $intOffset;
				$hdlReturn->intLimit =  $intLimit;
				$hdlReturn->strPrve = $strPrevPage;
				$hdlReturn->strNext = $strNextPage;
				$hdlReturn->strCurr = $strCurrPage;

	           return $hdlReturn;
	    }

	    


       /**
        * Function _fnUploadFile to upload file.Uploads muliple format files such as image,text,document,pdf,video,audio.
        * @param string $strOldFileName
		* @param string $strUpFileName
	  	* @param string $strFolderName
	  	* @param string $intHeightVal
	  	* @param string $intWidthVal
	  	* @param string $strFileTypes
        * @param int $height
		* @param int $width
		* @param string $strSmallImgNewFileName
        * @return mixed
        */

       function _fnUploadFile($strOldFileName,$strUpFileName,$strFolderName,$intHeightVal=0,$intWidthVal=0,$strFileTypes="img",$height=0,$width=0,$strSmallImgNewFileName="")
       {
       	/*ECHO " $strOldFileName ==><BR> $strUpFileName ==><BR>$strFolderName ==><BR>$intHeightVal ==><BR>,$intWidthVal==> <BR> $strFileTypes ==><BR> $height==><BR> $width ==> $strSmallImgNewFileName ";EXIT;*/
       	global $strImgFileNewNameTemp,$strSource,$strDest;


		
		  ### SOLID FILE UPLOADING CODE ###
		     #-- if file uploaded --#

		     if($strFileTypes == "img")
		     {
		     	$arrAllowImageTypes = array("jpg","jpeg","gif","png");
		     	//$arrAllowImageTypes = array("jpg");
		     	//$strFileTypes = "\"jpg\",\"jpeg\",\"gif\",\"png\"";
		     }
		     elseif ($strFileTypes == "doc")
		     { 
		     	$arrAllowImageTypes = array("doc","pdf","rtf","txt","xls","html","html","ppt","csv","docx","xlsx");
		     	//$strFileTypes = "\"doc\",\"pdf\",\"rtf\",\"txt\"";
		     }
		     elseif ($strFileTypes == "video")
		     {
		     	$arrAllowImageTypes = array("mp4","wmv","mov","mpg","avi","flv");
		     	//$arrAllowImageTypes = array("flv");
		     }
		     elseif ($strFileTypes == "podcast")
		     {
		     	$arrAllowImageTypes = array("mov","mp3","mpe","mp4","mpeg");
		     }
		     elseif ($strFileTypes == "csv")
		     {
		     	$arrAllowImageTypes = array("csv","xls","xlsx");
		     }
		     elseif ($strFileTypes == "resume")
		     {
		     	$arrAllowImageTypes = array("doc","pdf","rtf","txt","docx");
		     }


		  	 $strImgFileSize = (int)$_FILES[$strOldFileName]["size"];
		     if($strImgFileSize)
		     {
		     	if($strFileTypes=="video"&&$strImgFileSize>52428800)
		     	{
					   $strError .= "<p>Please upload video up to 50 MB.</p>";
		     	}
		     	elseif($strFileTypes=="img"&&$strImgFileSize>4194304)
		     	{
					$strErrorMessage .= "<p>Please upload image  up to 4 MB.</p>";
		     	}
		     	else
		     	{
		         $strFileSuccess=1;
		         $strImgFileName = $_FILES[$strOldFileName]["name"];
		         $strImgFileError = (int)$_FILES[$strOldFileName]["error"];
		         if($strImgFileError)
		         {
		            $strErrorMessage .= "<b>$strImgFileName</b> Error in uploaded File<br>"; $strFileSuccess=0;
		         }
		         if((int)$strFileSuccess)
		         {
		             $strImgFileName = $_FILES[$strOldFileName]["name"];
		             $strImgFileTmpName = $_FILES[$strOldFileName]["tmp_name"];

		              #-- get the file extention
		              $arrImgFileExtention = array_reverse(explode(".",$strImgFileName));
		              $strImgFileExtention = strtolower($arrImgFileExtention[0]);


		              #-- create new unique filename to avoide file overwriting situation --#
		                  $strImgFileNewNameTemp = $strUpFileName."_".time();
					        $strImgFileNewName = 	$strImgFileNewNameTemp.".".$strImgFileExtention;


		          if(!in_array($strImgFileExtention,$arrAllowImageTypes))
		            { 
		                $strErrorMessage .= "<b>$strImgFileExtention</b> File Type not allowed for $strImgFileName<br>"; $strFileSuccess=0;
						return "error=".$strErrorMessage;
		            }
					
		            if((int)$strFileSuccess)
		            {
		                 #-- move file to server --#
						if($strFileTypes == "img")
						{
								$arrHeightWidth = array();
							  // $arrHeightWidth = clsUtil::fnSetImageHeighWidth($strImgFileTmpName, $height, $width);
							 if($strSmallImgNewFileName != "")
							 {
							 	if($height == 0 && $width == 0)
							 	{
							 		if(!move_uploaded_file($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strSmallImgNewFileName))
									{
										$strErrorMessage .= "<b>$strImgFileName</b> File Could not upload<br>";
									}
							 	}
							 	else 
							 	{
									 if(ISLOCAL == 0)
										 clsUtil::image_resize($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strSmallImgNewFileName,$height,$width);
									 else
										 clsUtil::image_resize_local($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strSmallImgNewFileName,$height,$width);
							 	}
							 }
							 else
							 {
							 	if($height == 0 && $width == 0)
							 	{
							 		if(!move_uploaded_file($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strImgFileNewName))
									{
										$strErrorMessage .= "<b>$strImgFileName</b> File Could not upload<br>";
									}
							 	}
							 	else 
							 	{
									if(ISLOCAL == 0)
										clsUtil::image_resize($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strImgFileNewName,$height,$width);
									 else
										clsUtil::image_resize_local($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strImgFileNewName,$height,$width);
							 	}
							 }
						}
	     				else
						{
							if(!move_uploaded_file($strImgFileTmpName,DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strImgFileNewName))
							{
								$strErrorMessage .= "<b>$strImgFileName</b> File Could not upload<br>";
							}
							else
							{
								if($strFileTypes == "video")
								{
									if($strImgFileExtention!="flv")
									{
										$strSource = DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strImgFileNewName;
										$strDestinationFLV = DOCUMENT_ROOT."/usercontent/".$strFolderName."/".$strImgFileNewNameTemp.".flv";

										$output = clsUtil::runExternal("/usr/bin/ffmpeg -i $strSource -ar 22050 -ab 32 -f flv -s 320×240 $strDestinationFLV", $code );

										$strImgFileNewName = $strImgFileNewNameTemp.".flv";
										@unlink($strSource);

										if($code)
										$strErrorMessage .= "<p>Please check the file type.</p>";
									}
								 }
							  }
						   }
		              }
		         }
		       }
		  	}
		  	else
		    {
		       $strErrorMessage .= "<p>Please check the size.</p>";
		    }

		    if($strErrorMessage == "")
		    {
			    //------------insert record into log table Changes By Onkar for server migration on 26/03/09------//
			    $strImageLocationForLog = "usercontent/".$strFolderName."/".$strImgFileNewName;
		    	return "success=".$strImgFileNewName;
		    }
		    else
		    {
		    	return "error=".$strErrorMessage;
		    }

       }

	    /**
        * Function getPlainUrl returns plain url format
	  	* @param string $strUrl
        * @return string
        */

       function getPlainUrl($strUrl)
	   {
			//return preg_replace('/(^http:\/\/www\.|^www\.|^http:\/\/)/','',$strUrl);
			return preg_replace('/(^http:\/\/)/','',$strUrl);
	   }

       /**
        * Function fnValidateURL to Validate URL and to check whether URL exist or not
        * @param string $strUrl
        * @return bool
	  	*/
       function fnValidateURL($strUrl)
       {
       		$strUrl = trim($strUrl);

       		if($strUrl == "")
       		{
       			die("Functon: ".__FUNCTION__.">File: ".__FILE__.">> Enter value for strUrl ");
       		}
       		else
       		{
       			$strPlainUrl = clsUtil::getPlainUrl($strUrl);

       			$hdlFp = trim(@fopen("http://".$strPlainUrl, "r"));
       			if($hdlFp == "")
       			{
       				return false;
       			}
       			else
       			{
       				return true;
       			}
       		}
       }

	   /**
        * Function fnValidateCompanyDomain to validate company domain
        * @param string $string
        * @return string
	  	*/

       function fnValidateCompanyDomain($string)
	   {
	   		$string = preg_replace("/[^a-zA-Z0-9&]/", "",$string);
	   		$string = str_replace("&", "and",$string);
	   		return $string;
	   }

	   /**
        * Function fnValidateAlphNumricChars to validate if string is alphanumric character
        * @param string $string
        * @return bool
	  	*/

       function fnValidateAlphNumricChars($string)
		{
			//return preg_match("/[`_~!@#$%&,.:;'<>{}()=\/\"\/\*\/\-\/\^\/\+\/\|\/\/ ]/", $string);
			if(preg_match("/[`_~!@#$%&,.:;<>{}()=\/\"\/\*\/\\/\^\/\+\/\|\/\/]/", $string))
			{
				return true;
			}
			else
			{
			    return false;
			}

		}

		/**
        * Function fnValidateAlphNumricChars to validate if string is alphanumric character
        * @param string $string
        * @return bool
	  	*/
		function fnValidateCompanyName($string)
		{
			if(preg_match("/[`~!@#$%&,:;<>=\/\"\/\*\/\^\/\+\/\|\/\/]/", $string))
			{
			    return false;
			}
			return true;
		}

		/**
        * Function fnValidateFirstCharInString to validate first character in string
        * @param string $string
        * @return bool
	  	*/

		function fnValidateFirstCharInString($string)
		{
			$arrAlphabets =array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
			$string = strtolower($string);
			$chFirstChar = $string{0};
			if(!in_array($chFirstChar,$arrAlphabets))
			{
				return false;
			}
			else
			{
			    return true;
			}
		}

       
		function fnValidateEmail($email)
		{
		   $isValid = true;
		   $atIndex = strrpos($email, "@");
		   if (is_bool($atIndex) && !$atIndex)
		   {
		      $isValid = false;
		   }
		   else
		   {
		      $domain = substr($email, $atIndex+1);
		      $local = substr($email, 0, $atIndex);
		      $localLen = strlen($local);
		      $domainLen = strlen($domain);
		      if ($localLen < 1 || $localLen > 64)
		      {
		         // local part length exceeded
		         $isValid = false;
		      }
		      else if ($domainLen < 1 || $domainLen > 255)
		      {
		         // domain part length exceeded
		         $isValid = false;
		      }
		      else if ($local[0] == '.' || $local[$localLen-1] == '.')
		      {
		         // local part starts or ends with '.'
		         $isValid = false;
		      }
		      else if (preg_match('/\\.\\./', $local))
		      {
		         // local part has two consecutive dots
		         $isValid = false;
		      }
		      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		      {
		         // character not valid in domain part
		         $isValid = false;
		      }
		      else if (preg_match('/\\.\\./', $domain))
		      {
		         // domain part has two consecutive dots
		         $isValid = false;
		      }
		      else if
		      (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
		                 str_replace("\\\\","",$local)))
		      {
		         // character not valid in local part unless
		         // local part is quoted
		         if (!preg_match('/^"(\\\\"|[^"])+"$/',
		             str_replace("\\\\","",$local)))
		         {
		            $isValid = false;
		         }
		      }
		      // **** NOTE: If you are getting failures you may need to comment out this section
		      /*
		      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
		      {
		         // domain not found in DNS
		         $isValid = false;
		      }
		      */
		   }
		   return $isValid;
		}       
		
		function fnValidateEmailAddress($strEmail)
		{	 
			if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+(\.[a-z0-9-]+)*(\.[a-z]{2,3})+$/", $strEmail))
				return 1;
			else
				return 0;	
				
		}
	 /**
        * Function fnGetWYSIWYGeditor gets the editor.We can toggle the editor type by changing $strType value.
        * @param string $strElementName
        * @param string $strElementValue
        * @param int $intHeight
        * @param int $intWidth
        * @param string $strType
        * @return string
	  	*/

	 function fnGetWYSIWYGeditor($strElementName,$strElementValue="",$intHeight='400',$intWidth='300',$strType='tinymce', $strParentIFrameName = "")
	  {

		$arrElements = explode(",",$strElementName);

	  	//$strEditor = "<h4><img src='images/word.jpg' align='absmiddle'> Please use the <img src='".SITE_NAME."/lib/pear/tinymce/remove_formatting.jpg' align='absmiddle' /> icon when posting from Microsoft Word.</h4>";

	  	if($strType == "fckeditor")
	  	{

	  		$strElementName = $arrElements[0];
	  		include(DOCUMENT_ROOT."/lib/pear/fckeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor($strElementName) ;
			$oFCKeditor->BasePath = "lib/pear/fckeditor/";
			$oFCKeditor->Value = stripslashes($strElementValue);
			$oFCKeditor->Width = $intHeight;
			$oFCKeditor->Height = $intWidth;
			if($oFCKeditor->IsCompatible())
			{
				$strEditor .= "<div id='showloadingfckeditor' name='showloadingfckeditor'><img src='images/loading.gif' /> Loading Editor...</div>";
			}
			$strEditor .= $oFCKeditor->Create();
	  	}
	  	else
	  	{
			//$arrElements = explode(",",$strElementName);


			$strCount = count($arrElements);

			if( $strCount >  1)
			{

				// IF SESSION IS NOT SET
				if(!isset($_SESSION['ELECNT']))	$_SESSION['ELECNT'] = $strCount;
				if(isset($_SESSION['ELECNT']))
				{
					if((int)$_SESSION['ELECNT'] < $strCount)
					{
						$strElementName = $arrElements[0];
						$strEditor .= '<textarea id="'.$strElementName.'" name="'.$strElementName.'">'.$strElementValue.'</textarea>';
						//$_SESSION['ELECNT'] = $_SESSION['ELECNT'] - 1;
						if((int)$_SESSION['ELECNT'] <= 1)
						{
							unset($_SESSION['ELECNT']);
						}
						else
						{
							$_SESSION['ELECNT'] = $_SESSION['ELECNT'] - 1;
						}
						return 	$strEditor;
					}
					$_SESSION['ELECNT'] = $_SESSION['ELECNT'] - 1;
				}
			}
			else
			{
				unset($_SESSION['ELECNT']);
			}



					 $strEditor .= '<script type="text/javascript" src="'.SITE_NAME.'/lib/pear/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
						<script type="text/javascript">
					 
							function myCustomOnInit() {
					 			try 
					 			{	
					 				fnTinyMCECallBack();
					 			}
					 			catch(e)
					 			{
					 
					 			}
							}
					 
							tinyMCE.init({
								// General options
								mode : "exact",
								elements : "'.$strElementName.'",
								theme : "advanced",
								height : "'.$intHeight.'",
								width : "'.$intWidth.'",
								plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,media,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

								theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,fontsizeselect,forecolor,backcolor,|,bullist,numlist,|,pasteword",
								theme_advanced_buttons2 : "link,unlink,|,code,image,|,hr,charmap,iespell|,table,media",
								theme_advanced_buttons3 :"",

								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",

								// Replace values for the template plugin
								template_replace_values : {
									username : "Some User",
									staffid : "991234"
								},
					 			oninit : "myCustomOnInit"

							});
					 
					 
						</script>';

	  		    $strElementName = $arrElements[0];
				$strEditor .= '<textarea id="'.$strElementName.'" name="'.$strElementName.'">'.$strElementValue.'</textarea>';


	  	}

	  	return  $strEditor;
	  }

       /**
        * Function fnGetMonths to get month
        * @return array
	  	*/

	  function fnGetMonths()
		{
			return array("1"=>"January",
						"2"=>"February",
						"3"=>"March",
						"4"=>"April",
						"5"=>"May",
						"6"=>"June",
						"7"=>"July",
						"8"=>"August",
						"9"=>"September",
						"10"=>"October",
						"11"=>"November",
						"12"=>"December");
		}

       /**
        * Function fnGetDates to get dates
        * @return array
	  	*/

	  function fnGetDates()
	  {
	  		$arrDates = array();
	  		for($intCnt=1;$intCnt<=31;$intCnt++)
	  		{
	  			$arrDates[] = $intCnt;
	  		}

	  		return $arrDates;
	  }

	   /**
        * Function fnGetYear to get year
        * @return array
	  	*/

	  function fnGetYear($intPastLimit=0, $intFutureLimit=0)
	  {
	  		$arrYear = array();
	  		for($intYear=$intPastLimit;$intYear<=$intFutureLimit;$intYear++)
	  		{
	  			$arrYear[] = $intYear;
	  		}

	  		return $arrYear;
	  }

	  /**
        * Function fnGetHour to get hour
        * @return array
	  	*/

	  function fnGetHour($intStartLimit=0, $intEndLimit=0)
	  {
	  		$arrHour = array();
	  		for($intHour=$intStartLimit;$intHour<=$intEndLimit;$intHour++)
	  		{
	  			if ($intHour >0 && $intHour < 10)
	  			{
	  				$intHour = "0".$intHour;
	  			}
	  			$arrHour[] = $intHour;
	  		}

	  		return $arrHour;
	  }

	  /**
        * Function fnGetMinutes to get minute
        * @return array
	  	*/

	  function fnGetMinutes($intStartLimit=0, $intEndLimit=0)
	  {
	  		$arrMinutes = array();
	  		for($intMinutes=$intStartLimit;$intMinutes<=$intEndLimit;$intMinutes++)
	  		{
	  			if ($intHour >0 && $intHour < 10)
	  			{
	  				$intMinutes = "0".$intMinutes;
	  			}
	  			$arrMinutes[] = $intMinutes;
	  		}

	  		return $arrMinutes;
	  }

	  /**
        * Function fnSendMail for sendmail
        * @param string $strSender
        * @param string $strRecepient
		* @param string $strSubject
		* @param string $strMessage
        * @return string

	  	*/

       function fnSendHtmlMail($strSender,$strRecepient,$strSubject="",$strMessage="")
       {
			if(SITE_NAME == "localhost")
		    {
	       		//$headers = 'From: '.$strSender . "\r\n" .
	       		//$headers = 'From: noreply@justmeans.com\r\n'.'X-Mailer: PHP/' . phpversion();
	       		$headers = "From: Justmeans <noreply@justmeans.com>\r\n";
	       		#$headers .= "Bcc: onkart.pathsol@gmail.com,abhishekp.pathsol@gmail.com,tusharc.pathsol@gmail.com\r\n";
	       		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
			     /*if($_SERVER['REMOTE_ADDR'] == "122.170.28.143")
			     {
			     	return "$strRecepient, $strSubject, $strMessage, $headers";
			     } */
			    mail($strRecepient, $strSubject, $strMessage, $headers);
			    $boolMailSentOrNot = 1;
			    if($boolMailSentOrNot)
			    {
			    	return "<b>Mail has been successfully sent</b>";
			    }
			    else
			    {
			    	return "<b>Error sending mail. Check EMail Address</b>";
			    }
		    }
		    else
		    {
				return "<b>Mails are blocked on local server </b>";
				//return "<b>Error sending mail. Check Email Address</b>";
		    }
       }



	  /**
        * Function fnMail will return true or false on sending mail
        * @param string $strSender
        * @param string $strRecepient
		* @param string $strSubject
		* @param string $strMessage
        * @return true|false

	  	*/

       function fnMail($strSender,$strRecepient,$strSubject="",$strMessage="")
       {
			 if(SITE_NAME == "localhost")
		    {

			    $headers = "From: Justmeans <noreply@justmeans.com>\r\n";
			    #$headers .= "Bcc: onkart.pathsol@gmail.com,abhishekp.pathsol@gmail.com,tusharc.pathsol@gmail.com\r\n";
	       		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
			    return @mail($strRecepient, $strSubject, $strMessage, $headers);
		    }
		    else
		    {
		    	return true;
		    }
       }

       /**
        * Function fnSendHTMLEmail for sending html emails
        * @param string $strSender
        * @param string $strRecepient
		* @param string $strSubject
		* @param string $strMessage
		* @param string $strBounceEmailReciever
		* @param array $arrMsgValues

        * @return mixed

	  	*/

       function fnSendHhtmlMailNew($strSender,$strRecepient,$strSubject="",$strMessage="", $strBounceEmailReciever="", $arrMsgValues = "")
       { 
            //REWORK ON THIS FUNCTION -> VIKRANT 
       }
	
	  /**
        * Function fnSetImageHeighWidth to set Image Height and Width
		* @param string $strfilename
		* @param int $intTargetHeight
		* @param int $intTargetWidth
		* @param int $intActualHeight
		* @param int $intActualWidth
        * @return mixed
        * @return int
	  	*/

      function fnSetImageHeighWidth($strfilename, $intTargetHeight, $intTargetWidth, $intActualHeight=0,$intActualWidth=0)
	  {
		 $arrHeightWidth = array();
		 if($intActualHeight==0 && $intActualWidth==0)
		 {
		 	list($intWidth, $intHeight, $strFileType) = @getimagesize($strfilename);
		 }
		 else
		 {
		 	$intWidth = $intActualWidth;
			$intHeight = $intActualHeight;
		 }

		 $arrHeightWidth['filetype'] = $strFileType;

		 if($intWidth == 0 || $intHeight == 0)
		 {
		 	  $arrHeightWidth['width']  = $intWidth;
			  $arrHeightWidth['height'] = $intHeight;
		 	return $arrHeightWidth;
		 }

		 if ($intWidth > $intTargetWidth)
		 {
			  $intNewWidth  = $intTargetWidth;
			  $intNewHeight = round(($intHeight * $intNewWidth)/$intWidth);
			  if ($intNewHeight > $intTargetHeight)
			  {
				  $intNewHeight = $intTargetHeight;
				  $intNewWidth  = round(($intWidth * $intNewHeight)/$intHeight);
			  }
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
		 }
		 elseif ($intHeight > $intTargetHeight)
		 {
			  $intNewHeight = $intTargetHeight;
			  $intNewWidth  = round(($intWidth * $intNewHeight)/$intHeight);
			  if ($intNewWidth > $intTargetWidth)
			  {
				  $intNewWidth  = $intTargetWidth;
				  $intNewHeight = round(($intHeight * $intNewWidth)/$intWidth);
			  }
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
		 }
	 	 elseif ($intWidth == $intHeight && $intWidth > $intTargetWidth)
	 	 {
			  $intNewWidth  = $intTargetWidth;
			  $intNewHeight = round(($intHeight * $intNewWidth)/$intWidth);
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
	 	 }
	 	 elseif ($intWidth == $intHeight && $intHeight > $intTargetHeight)
	 	 {
			  $intNewHeight = $intTargetHeight;
			  $intNewWidth  = round(($intWidth * $intNewHeight)/$intHeight);
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
	 	 }
	 	 elseif ($intWidth < $intTargetWidth)
	 	 {
			  $intNewWidth  = $intTargetWidth;
			  $intNewHeight = round(($intHeight * $intNewWidth)/$intWidth);
			  if ($intNewHeight > $intTargetHeight)
			  {
				  $intNewHeight = $intTargetHeight;
				  $intNewWidth  = round(($intWidth * $intNewHeight)/$intHeight);
			  }
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
	 	 }
		 elseif ($intHeight < $intTargetHeight)
		 {
			  $intNewHeight = $intTargetHeight;
			  $intNewWidth  = round(($intWidth * $intNewHeight)/$intHeight);
			  if ($intNewWidth > $intTargetWidth)
			  {
				  $intNewWidth  = $intTargetWidth;
				  $intNewHeight = round(($intHeight * $intNewWidth)/$intWidth);
			  }
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
		 }
	 	 elseif ($intWidth == $intHeight && $intWidth < $intTargetWidth)
	 	 {
			  $intNewWidth  = $intTargetWidth;
			  $intNewHeight = round(($intHeight * $intNewWidth)/$intWidth);
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
	 	 }
	 	 elseif ($intWidth == $intHeight && $intHeight < $intTargetHeight)
	 	 {
			  $intNewHeight = $intTargetHeight;
			  $intNewWidth  = round(($intWidth * $intNewHeight)/$intHeight);
			  $arrHeightWidth['width']  = $intNewWidth;
			  $arrHeightWidth['height'] = $intNewHeight;
	 	 }
	 	 else
	 	 {
	 	  	$arrHeightWidth['width']  = $intWidth;
		  	$arrHeightWidth['height'] = $intHeight;
	 	 }
		 return $arrHeightWidth;
	}


	/**
	    * Function fnValidatePostData will parse the Postdata and Generate
	    * ad error message according to the Formula array we send
	    * as parameter
	    *
	    * @param array $arrValidation
	    * @return string $strErrorMsg
	    */
	   function fnValidatePostData($arrValidation=array(),$strReturnErrorFields=false,$strImageBreak=0,$strReturnMsgs=0)
	   {
	   		if($strImageBreak==1)
				$strLineBreak = "<br /><img src=\"images/error_small.jpg\" alt=\"error\" border=\"0\" align=\"absmiddle\"  /> ";
			else
				$strLineBreak = " <br />";
				
	   		$strErrorMsg = false;

			$arrReturnErrorFields = array();

	   		if(is_array($this->P))
  			{
  				if(count($this->P))
  				{
  					foreach($this->P as $strFieldName=>$strPostValue)
  					{
						$enmIsErrror = false;
  						$strPostValue = trim($strPostValue);
  						if(array_key_exists($strFieldName,$arrValidation))
  						{
  							$strValue = $arrValidation[$strFieldName];
  							$arrValue = explode(":",$strValue);
  							if(is_array($arrValue))
  							{
  								if(count($arrValue))
  								{
  									foreach ($arrValue as $intKey=>$strFormula)
  									{
  										$strFormula = trim($strFormula);
  										$arrFormula = explode("-",$strFormula);
  										if($arrFormula[0] == "M") // MANDATORY FIELD VALIDATION
  										{
  											if($strPostValue == "")
  											{
												if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
												else $strErrorMsg = $arrFormula[1];

												$enmIsErrror = true;
  											}
  										}
  										if($arrFormula[0] == "E") // EMAIL VALIDATION
  										{
  											if($strPostValue != "")
  											{
  												if(!clsUtil::fnValidateEmail($strPostValue))
  												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  												}
  											}
  										}
  										if($arrFormula[0] == "COMPANYNAME") // EMAIL VALIDATION
  										{
  											if($strPostValue != "")
  											{
  												if(!clsUtil::fnValidateCompanyName($strPostValue))
  												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  												}
  											}
  										}
  										if($arrFormula[0] == "CHAR") // STRING VALIDATION
  										{
  											if($strPostValue != "")
  											{
  										   		if ( preg_match('!^[^a-zA-Z]+$!', $strFirstName) == 1 )
  												  {
														if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
														else $strErrorMsg = $arrFormula[1];

														$enmIsErrror = true;
  												  }
  											}
  										}
  										if($arrFormula[0] == "PH") // PHONE VALIDATION
  										{
  											if($strPostValue != "")
  											{
  												if(!clsUtil::fnValidatePhone($strPostValue))
  												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  												}
  											}
  										}

  										if($arrFormula[0] == "SEL") // SELECT VALIDATION
  										{
  											if($strPostValue == "")
  											{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  											}
  										}
  										if($arrFormula[0] == "CHK") // CHECK BOX FIELD VALIDATION
  										{
  											if($strPostValue == false)
  											{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  											}
  										}

  										if($arrFormula[0] == "NUM") // MANDATORY FIELD VALIDATION
  										{
  											if($strPostValue != "")
  											{
  												if(!(int)($strPostValue))
  												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  												}
  											}
  										}

  										if($arrFormula[0] == "MIN") // MINIMUM LIMIT
  										{
											if ($strPostValue != "")
											{
												$intLimit = strlen($strPostValue);
												if($intLimit < (int)$arrFormula[1])
												{
														if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[2];
														else $strErrorMsg = $arrFormula[2];

														$enmIsErrror = true;
												}
											}
  										}

  										if($arrFormula[0] == "MAX") // MAXIMUM LIMIT
  										{
											if ($strPostValue != "")
											{
												$intLimit = strlen($strPostValue);
												if($intLimit > (int)$arrFormula[1])
												{
														if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[2];
														else $strErrorMsg = $arrFormula[2];

														$enmIsErrror = true;
												}
											}
  										}

  										if($arrFormula[0] == "BET") // BETWEEN LIMIT
  										{
  											$intLimit = strlen($strPostValue);
  											if($intLimit < (int)$arrFormula[1] && $intLimit > (int)$arrFormula[2])
  											{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[3];
													else $strErrorMsg = $arrFormula[3];

													$enmIsErrror = true;
  											}
  										}

  										if($arrFormula[0] == "COMP") // COMPARISION BETWEEN TWO FIELDS
  										{
  											$strCompValue = trim($this->P[$arrFormula[2]]);
  											if($strCompValue != "")
  											{
  												if($arrFormula[1] == "==")
  												{
  													if($strPostValue != $strCompValue)
  													{
														if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[3];
														else $strErrorMsg = $arrFormula[3];

														$enmIsErrror = true;
  													}
  												}
  												if($arrFormula[1] == "!=")
  												{
  													if($strPostValue == $strCompValue)
  													{
														if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[3];
														else $strErrorMsg = $arrFormula[3];

														$enmIsErrror = true;
  													}
  												}
  											}
  										}

  										if($arrFormula[0] == "COMPOR") // COMPARISION BETWEEN TWO FIELDS
  										{
											if($this->P[$arrFormula[1]] != "" && $this->P[$arrFormula[2]] != "")
											{
												if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[3];
												else $strErrorMsg = $arrFormula[3];

												$enmIsErrror = true;
											}

											if($this->P[$arrFormula[1]] == "" && $this->P[$arrFormula[2]] == "")
											{
												if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[3];
												else $strErrorMsg = $arrFormula[3];

												$enmIsErrror = true;
											}
  										}

  										if($arrFormula[0] == "COMPALL") // COMPARISION BETWEEN TWO FIELDS
  										{
  											$strPostFields = $arrFormula[1];
  											$arrPostFields = explode("|",$strPostFields);

  											if(count($arrPostFields) > 0 && is_array($arrPostFields))
											{
												$intFilledData = 0;
												foreach ($arrPostFields as $strPostField)
												{
													if ($this->P[$strPostField] != "")
													{
														$intFilledData++;
													}
												}

												if ($intFilledData != 0 && $intFilledData != count($arrPostFields))
												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[2];
													else $strErrorMsg = $arrFormula[2];

													$enmIsErrror = true;
												}
											}
  										}

  										if($arrFormula[0] == "URL") // URL VALIDATION
  										{
  											if($strPostValue != "")
  											{
  												if(!clsUtil::fnValidateUrl($strPostValue))
  												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  												}
  											}
  										}

  										if($arrFormula[0] == "ARRCOUNT") // ARRAY COUNT
  										{
  											if($strPostValue != "")
  											{
  												if(count($strPostValue) == 0)
  												{
													if($strErrorMsg) $strErrorMsg = $strErrorMsg . $strLineBreak . $arrFormula[1];
													else $strErrorMsg = $arrFormula[1];

													$enmIsErrror = true;
  												}
  											}
  										}
  									}
  								}
  							}
  						}
						if($enmIsErrror && $strReturnErrorFields)
						{
							if($strReturnMsgs==1)
								$arrReturnErrorFields[] = $strLineBreak.$arrFormula[1];
							else
								$arrReturnErrorFields[] = $strFieldName;
						}
  					}
  				}
  			}
			if ($strReturnErrorFields)
		    {
				return $arrReturnErrorFields;
		    }
			else
				return $strErrorMsg;
	   }

	/**
	    * Function image_resize will resize the target image
	    * @param string $source
	    * @param string $dest
	    * @param int $targetHeight
	    * @param int $targetWidth
	    * @param bool $isFileStore
	    * @return string
	    */

	 function image_resize($source, $dest, $targetHeight=75, $targetWidth=100, $isFileStore=0)
  	  {

			 $image = new Imagick($source);

			 $intActualheight = $image->getImageHeight(); // GET ACTUAL HEIGHT
			 $intActualWidth = $image->getImageWidth(); // GET ACTUAL WIDTH


			 $arrDimentions = clsUtil::fnSetImageHeighWidth($source, $targetHeight, $targetWidth, (int)$intActualheight, (int)$intActualWidth);


			// If 0 is provided as a width or height parameter,
			// aspect ratio is maintained
			$image->thumbnailImage($arrDimentions['width'], $arrDimentions['height']);

			if($isFileStore == 0)
			{

			  $image->writeImage($dest);
			}
			else
			{
			 //Array ( [width] => 80 [height] => 75 )
			 // $strNewImage = $image;
			  return $arrDimentions;

			}
			$image->clear();
			$image->destroy();
		}

		/**
	    * Function image_resize_local will resize the target image
	    * @param string $source
	    * @param string $dest
	    * @param int $targetHeight
	    * @param int $targetWidth
	    * @return string
	    */

		function image_resize_local($source, $dest, $targetHeight=75, $targetWidth=100)
		 {
		  $image_info = @getImageSize($source) ; // see EXIF for faster way

		  switch ($image_info['mime'])
		  {
		     case 'image/gif':
		         if (imagetypes() & IMG_GIF)   // not the same as IMAGETYPE
		         {
		             $src_handle = imageCreateFromGIF($source) ;
		         }
		         else
		         {
		             $ermsg = 'GIF images are not supported<br />';
		         }
		        break;
		     case 'image/jpeg':
		         if (imagetypes() & IMG_JPG)
		         {
		             $src_handle= imageCreateFromJPEG($source) ;
		         }
		         else
		         {
		             $ermsg = 'JPEG images are not supported<br />';
		         }
		        break;
		     case 'image/png':
		         if (imagetypes() & IMG_PNG)
		         {
		             $src_handle = imageCreateFromPNG($source) ;
		         }
		         else
		         {
		             $ermsg = 'PNG images are not supported<br />';
		         }
		        break;
		     case 'image/wbmp':
		         if (imagetypes() & IMG_WBMP)
		         {
		             $src_handle = imageCreateFromWBMP($source) ;
		         }
		         else
		         {
		             $ermsg = 'WBMP images are not supported<br />';
		         }
		        break;
		     default:
		         $ermsg = $image_info['mime'].' images are not supported<br />';
		        break;
		  }

		  if (!isset($ermsg))
		  {
		   $org_w = imagesx($src_handle) ;
		   $org_h = imagesy($src_handle) ;
		   $width=$org_w;
		   $height=$org_h;

		   $arrDimentions = clsUtil::fnSetImageHeighWidth($source, $targetHeight, $targetWidth);

		   $dest_handle = imageCreateTrueColor($arrDimentions['width'],$arrDimentions['height']);
		   imageCopyResampled($dest_handle,$src_handle , 0, 0, 0, 0, $arrDimentions['width'],$arrDimentions['height'],$org_w,$org_h);
		   imageJPEG($dest_handle,$dest);
		   imageDestroy($src_handle );
		   imageDestroy($dest_handle);
		  }
		  return isset($ermsg)?$ermsg:NULL;
		 }


		 /**
	    * Function fnYouTubeImage to get youtube image
	    * @param string $strHtml
	    * @param object $hdlDb
	    * @param int $intCompanyId
	    * @return string
	    */
		 // FUNCTION TO GET YOUTUBE IMAGE
		function fnYouTubeImage($strHtml,$hdlDb="",$intCompanyId=0)
		{
			$strPattern = "/src=[\"]?([^\"']?.*)[\"]/i";
			preg_match_all($strPattern, $strHtml, $arrUrls);
			list($strSrcUrl,$strRawUrl) = explode("type", $arrUrls[1][0]);
			$strSrc = str_replace('"','',$strSrcUrl);
			
			list($strPerfectUrl,$strQString) = explode("&",$strSrc);
			
			preg_match('@^(?:http://)?([^/]+)@i', $strPerfectUrl, $arrDomain);
			$strDomain = $arrDomain[1];
			
			preg_match('/[^.]+\.[^.]+$/', $strDomain, $arrMatchDomain);
			$strMatchDomain = $arrMatchDomain[0];
			
			$arrUrlInfo = parse_url($strPerfectUrl);

			list($strBlank,$strFirstDir,$strLastDir) = explode("/", $arrUrlInfo['path']);
			//to avoid '%20' problem if whitespace is there which cause returning empty value
			
			$strBlank = trim($strBlank);
			$strFirstDir = trim($strFirstDir);
			$strLastDir = trim($strLastDir);
			$strYouTubeImage = "http://img.$strMatchDomain/$strFirstDir"."i"."/$strLastDir/2.jpg";
			
			if(!clsUtil::fnValidateURL($strYouTubeImage))
			{
				if($intCompanyId&&$hdlDb!="")
				{
					$strCompanyLogoQuery = "SELECT logofile,logofile_ext
													FROM
														  jm_user_companyinfo
													WHERE
														  userid = '$intCompanyId'";

					$arrCompanyLogo = $hdlDb->queryAll($strCompanyLogoQuery,null,2);
					if($arrCompanyLogo[0]['logofile']!=""&&$arrCompanyLogo[0]['logofile_ext']!="")
					{
						$strYouTubeImage = SITE_NAME."/usercontent/companylogo/".$arrCompanyLogo[0]['logofile'].".".$arrCompanyLogo[0]['logofile_ext'];
					}
					else
					{
						$strYouTubeImage = SITE_NAME."/images/no-photo-lg.gif";
					}
				}
				else
				{
					$strYouTubeImage = SITE_NAME."/images/no-photo-lg.gif";
				}
			}

			return $strYouTubeImage;
		}


		/* catch Video image */
		 /**
	    * Function runExternal to catch Video image
	    * @param string $cmd
	    * @param string $code
	    * @return string
	    */
		function runExternal( $cmd, &$code )
		{
			$descriptorspec = array(
			0 => array("pipe", "r"), // stdin is a pipe that the child will
			1 => array("pipe", "w"), // stdout is a pipe that the child will
			2 => array("pipe", "w") // stderr is a file to write to
			);

			$pipes= array();
			$process = proc_open($cmd, $descriptorspec, $pipes);

			$output= "";

			if (!is_resource($process)) return false;

			#close child's input imidiately
			fclose($pipes[0]);

			stream_set_blocking($pipes[1],false);
			stream_set_blocking($pipes[2],false);

			$todo= array($pipes[1],$pipes[2]);

			while( true ) {
			$read= array();
			if( !feof($pipes[1]) ) $read[]= $pipes[1];
			if( !feof($pipes[2]) ) $read[]= $pipes[2];

			if (!$read) break;

			$ready= stream_select($read, $write=NULL, $ex= NULL, 2);

			if ($ready === false) {
			break; #should never happen - something died
			}

			foreach ($read as $r) {
			$s= fread($r,1024);
			$output.= $s;
			}
			}

			fclose($pipes[1]);
			fclose($pipes[2]);
			$code= proc_close($process);


			return $output;
		}

		 /**
	    * Function fnConvertImageFromVideo to capture image from video
	    * @param string $strVideoSourcePath
	    * @param string $strVideoImageDest
	    * @param int $intTime
	    * @return string
	    */

	    function fnConvertImageFromVideo($strVideoSourcePath,$strVideoImageDest,$intTime="1")
	    {
			$output = clsUtil::runExternal("/usr/bin/ffmpeg -i $strVideoSourcePath -deinterlace -an -ss $intTime -t 00:00:01 -r 1 -y -s 320×240 -vcodec mjpeg -f mjpeg $strVideoImageDest", $code );
 			return $code;
	    }

	    /**
	    * Function fnParseFeedLib to parse rss feeds
	    * @param string $strURL
	    * @return object Handler
	    */
	   function fnParseFeedLib($strURL)
       {
       		/* 	RSS PARSER CALSS */
   			require_once('magpierss/rss_fetch.inc');
   			$hdlRss = fetch_rss($strURL);

   			$arrFeedInfo = array();
   			//CHANNLE INFORMATION / FEED INFORMATION
   			$arrFeedInfo['strFeedTitle'] = $hdlRss->channel['title'];
   			$arrFeedInfo['strFeedLink'] = $hdlRss->channel['link'];
   			$arrFeedInfo['strFeedDescription'] = $hdlRss->channel['description'];
   			$arrFeedInfo['strFeedGenerator'] = $hdlRss->channel['generator'];
   			$arrFeedInfo['strFeedType'] = trim($hdlRss->feed_type);
   			$strFeedType = trim($hdlRss->feed_type);
   			$arrFeedInfo['strFeedVersion'] = trim($hdlRss->feed_version);

   			//print "strFeedTitle = $strFeedTitle <br>strFeedLink = $strFeedLink <br>strFeedDescription = $strFeedDescription  <br>strFeedGenerator = $strFeedGenerator  <br>strFeedType = $strFeedType  <br>strFeedVersion = $strFeedVersion  <br>";exit;

   		//	print_r($hdlRss->channel['link']);
   			$arrPostInfo = array();
   			$intCtr = 0;

   			if(is_object($hdlRss))
   			{
   				foreach ($hdlRss->items as $arrItem)
				{
					if($strFeedType == "RSS")
					{
						$strPostUrl = $arrItem['link'];
						$strPostTitle = $arrItem['title'];
						$strPostContent =  $arrItem['description'];
						$strPostId = $arrItem['guid'];
						$strAuthorName = $arrItem['author'];
						$strTimestamp = $arrItem['date_timestamp'];
						$strPublishDate = $arrItem['pubdate'];
						//$strPostDate = ($strTimestamp == "")?$strPublishDate:$strTimestamp;
						$strPostDate =$strPublishDate;


					}
					elseif($strFeedType == "Atom")
					{
						$strPostUrl = $arrItem['link'];
						$strPostTitle = $arrItem['title'];
						$strPostContent = $arrItem['atom_content'];
						$strPostId = $arrItem['id'];
						$strAuthorName = $arrItem['author_name'];
						$strTimestamp = $arrItem['date_timestamp'];
						$strPublishDate = (trim($arrItem['published']) == "")?trim($arrItem['issued']):trim($arrItem['published']);
						$strPostDate = ($strTimestamp == "")?$strPublishDate:$strTimestamp;
						$strPostImage = (trim($arrItem['link_image']) != "")?trim($arrItem['link_image']):"";
						$strPostThread = (trim($arrItem['link']) != "")?trim($arrItem['link']):"";

					}


					//$strPostTitle  = htmlspecialchars($strPostTitle);
					//$strPostContent  = htmlspecialchars($strPostContent);

					$arrPostInfo[$intCtr]['strPostUrl'] = $strPostUrl;
					$arrPostInfo[$intCtr]['strPostTitle'] = $strPostTitle;
					$arrPostInfo[$intCtr]['strPostContent'] = $strPostContent;
					$arrPostInfo[$intCtr]['strPostId'] = $strPostId;
					$arrPostInfo[$intCtr]['strAuthorName'] = $strAuthorName;
					$arrPostInfo[$intCtr]['strPostDate'] = $strPostDate;
					$arrPostInfo[$intCtr]['strPostImage'] = $strPostImage;
					$arrPostInfo[$intCtr]['strPostlink'] = $strPostThread;

					$intCtr++;
				}
   			}
			$hdlReturn = new stdClass;
	        $hdlReturn->feedinfo = $arrFeedInfo;
	        $hdlReturn->feedposts = $arrPostInfo;

	        return $hdlReturn;
       }

     
     /**
	* Function fnReplaceSpecialCharWithHypen to replace special character with Hypen
	* @param string $strInput
	* @return string
	*/

     function fnReplaceSpecialCharWithHypen($strInput)
     {
		$strInput = str_replace("?","",preg_replace("/[®©™]/", "-",utf8_decode($strInput)));
     	return str_replace("?","",utf8_decode(preg_replace("/[`_~!@#$%&,.:;?'<>\[\]{}()=\/\"\/\*\/\-\/\^\/\+\/\|\/\/ ]/", "-",$strInput)));
     }

	/**
	* Function addslashes to add slashes to given text
	* @param string $strString
	* @return string
	*/

	function addslashes($strString)
	{
		if(!get_magic_quotes_gpc())
			return addslashes($strString);
		else
			return $strString;
	}


	/**
	* Function html2text to convert html to text
	* @param string $html
	* @return object
	*/
	function html2text( $html )
	{
	   // Include the class definition file.
		require_once( DOCUMENT_ROOT.'/inc/class.html2text.php');

		// Instantiate a new instance of the class. Passing the string
		// variable automatically loads the HTML for you.

		$h2t =& new html2text($html);

		// Simply call the get_text() method for the class to convert
		// the HTML to the plain text. Store it into the variable.
		$text = $h2t->get_text();
		return $text;


	}

	/**
	* Function html2text to convert html to text
	* @param string $html
	* @return object
	*/
	function fnRemoveExternalHtmlLinks( $html )
	{
		$search = array(
							'/<script[^>]*>.*?<\/script>/i',  // <script>s -- which strip_tags supposedly has problems with
							'/<style[^>]*>.*?<\/style>/i',    // <style>s -- which strip_tags supposedly has problems with
						);
	    $replace = array(
							'',
							'',
						);
        return $html = preg_replace($search, $replace, $html);
	}

	/**
	* This function Remmoves special character's added through Msword.
	*
	* @param sting $text
	* @return string
	*
	*/
	function fnRemoveWordFormatting($strMsWordText)
	{
			$search = array(
					'/(%E2%80%93|%u2013|%u2026|%u2014|%96)/i',
					'/(%E2%80%9C|%E2%80%9D|%u201C|%u201D|%93|%94)/i',
					'/(%E2%80%98|%E2%80%99|%u2018|%u2019|%91|%92)/i',
					'/(%95%09)/',
					);

			$replace = array(
							'-',
							'"',
							"'",
							"- ",
							);

			$strMsWordText =  preg_replace($search, $replace, $strMsWordText);
			return urldecode(preg_replace($search, $replace, urlencode($strMsWordText)));
			
	}

	/**
	    * Function fnDistance to calculate distance between two latitude and longitude
	    * @param int $lat1
	    * @param int $lon1
        * @param int $lat2
        * @param int $lon2
        * @param int $unit
	    * @return int
	    */

	function fnDistance($lat1, $lon1, $lat2, $lon2, $unit)
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
		return ($miles * 1.609344);
		} else if ($unit == "N") {
		return ($miles * 0.8684);
		} else {
		return $miles;
		}
	}

		/**
		* Function to retrive first Image src for given html string
		*
		* @param string $html
		* @return string $matches[2]
		*
		*/
		 function fnGetImageSrcFromHtml($html)
		 {
			if (stripos($html, '<img') !== false)
			{
				$imgsrc_regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
				preg_match($imgsrc_regex, $html, $matches);
				unset($imgsrc_regex);
				unset($html);

				if (is_array($matches) && !empty($matches))
				{
					return $matches[2];
				}
				else
				{
					return false;
				}
			}
			 else
			{
				return false;
			}
		}
		/**********************************************************/
			//GET Multiple Image source
			
		


		function fnGetUrlFromHtml($strPattern, $strSearch, $strHtml)
		{ 
			
			@preg_match_all("/(<".$strPattern." .*?".$strSearch.".*?=.*?\")(.*?)(\".*?>)/", $strHtml, $matches);
			$arrImageSrc = $matches[2];			
			
			if(is_array($arrImageSrc) && count($arrImageSrc) > 0 )
			{
				foreach ($arrImageSrc as $intkeyVal=> $strGetImageSrcDtl)
				
				{
					if((substr(trim($strGetImageSrcDtl),0,4) != "http") )
					{ 
						if(strstr(trim(strtolower($strGetImageSrcDtl)),"mailto") == "")
						{
							$strImageSrcDtl = SITE_NAME."/".$strGetImageSrcDtl;														
							
							$strHtml = str_replace($strGetImageSrcDtl,$strImageSrcDtl,$strHtml);							
							
						}
					}
				}
			}
			return $strHtml;
		}

		function fnGetMultipleImageSrcFromHtml($strPattern, $strSearch, $strHtml,$intFlag = 0)
		{
			@preg_match_all("/(<".$strPattern." .*?".$strSearch.".*?=.*?\")(.*?)(\".*?>)/", $strHtml, $matches);
			$arrImageSrc = array();
			$arrImageSrc = $matches[2];

			if(is_array($arrImageSrc) && count($arrImageSrc) > 0 )
			{
				foreach ($arrImageSrc as $intkeyVal=> $strGetImageSrcDtl)
				{
					$strImageSrcDtl = $strGetImageSrcDtl;

					if($strImageSrcDtl !="")
					{
						list($width, $height, $type, $attr) = @getimagesize($strImageSrcDtl);

						if($width > 400)
						{
							$arrDimentions = clsUtil::fnSetImageHeighWidth($strImageSrcDtl, 370, 250, $height, $width);
							$intHeight = $arrDimentions['height'];
							$intWidth = $arrDimentions['width'];
							$strImageTag = "$strImageSrcDtl\" height=\"$intHeight\" width=\"$intWidth\"";

							if($intFlag ==1)
								$strHtml = ereg_replace("<img[^>]*>", "", $strHtml);
							else
								$strHtml = str_replace($strImageSrcDtl."\"",$strImageTag,$strHtml);
						}
					}
				}
			}
			return $strHtml;
		}
		/**********************************************************/
		/**
		* Function resize the Image on the fly with Imagemagick
		*
		* @param sting $strSrc
		* @param sting $intHeight
		* @param sting $intWidth
		*
		*/
		function fnOnTheFlyImageResize($strSrc,$intHeight,$intWidth)
		{
			$strImageSrc = $strSrc;
			$strImageH = $intHeight;
			$strImageW = $intWidth;



			if(substr(trim($strImageSrc),0,4) == "http")
			{
				// SITENAME
				$strImageSrc = str_replace(SITE_NAME."/","",$strImageSrc);
				if(substr(trim($strImageSrc),0,4) == "user")
				{
					// NOT BSE64 DEODED
					$strImageSrc = base64_encode($strImageSrc);
				}

				if(substr(trim($strImageSrc),0,9) == "editorial")
				{
					// NOT BSE64 DEODED
					$strImageSrc = base64_encode($strImageSrc);
				}
			}
			elseif(substr(trim($strImageSrc),0,4) == "user")
			{
				// NOT BSE64 DEODED
				$strImageSrc = base64_encode($strImageSrc);
			}
			elseif(substr(trim($strImageSrc),0,5) == "/user")
			{
				// NOT BSE64 DEODED
				$strImageSrc = substr_replace("/", '', 0, 1);
				$strImageSrc = base64_encode($strImageSrc);
			}


			if(!$strImageH)
			{
				$strImageH = "70";
			}
			if(!$strImageW)
			{
				$strImageW = "70";
			}

			if($strImageSrc != "")
			{
			   // Decode image from base64
				 $image=base64_decode($strImageSrc);
				 //$image=$strImageSrc;

				 // Create Imagick object
				 $im = new Imagick();

				 // Convert image into Imagick
				 $im->readImage(DOCUMENT_ROOT."/".$image);
				 //$im->readImage($image);

				// Create thumbnail max of 200x82
				$im->thumbnailImage($strImageW,$strImageH,true);
				// Add a subtle border
				$color=new ImagickPixel();
				$color->setColor("rgb(220,220,220)");
				$im->borderImage($color,1,1);

			   // Output the image
			   $output = $im->getimageblob();
			   $outputtype = $im->getFormat();
			 // unset($im);
			  header("Content-type: $outputtype");
			  print $output;
			}

		}
		###############################################################################################
		// HTML WRAP Function


		function fnHtmlwrap($str, $width = 60, $break = "\n", $nobreak = "code pre")
		{
			/*
			print $strWordWrap = wordwrap($str,$width);
			return($strWordWrap);*/

			// Split HTML content into an array delimited by < and >
			// The flags save the delimeters and remove empty variables
			$content = preg_split("/([<>])/", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

			// Transform protected element lists into arrays
			$nobreak = explode(" ", strtolower($nobreak));

			// Variable setup
			$intag = false;
			$innbk = array();
			$drain = "";

			// List of characters it is "safe" to insert line-breaks at
			// It is not necessary to add < and > as they are automatically implied
			$lbrks = "/?!%)-}]\\\"':;&";

			// Is $str a UTF8 string?
			$utf8 = (preg_match("/^([\x09\x0A\x0D\x20-\x7E]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})*$/", $str)) ? "u" : "";

			while (list(, $value) = each($content))
			{
				switch ($value)
				{
					// If a < is encountered, set the "in-tag" flag
					case "<": $intag = true; break;

					// If a > is encountered, remove the flag
					case ">": $intag = false; break;

					default:

					// If we are currently within a tag...
					if ($intag)
					{

						// Create a lowercase copy of this tag's contents
						$lvalue = strtolower($value);

						// If the first character is not a / then this is an opening tag
						if ($lvalue{0} != "/")
						{

							// Collect the tag name
							preg_match("/^(\w*?)(\s|$)/", $lvalue, $t);

							// If this is a protected element, activate the associated protection flag
							if (in_array($t[1], $nobreak)) array_unshift($innbk, $t[1]);

							// Otherwise this is a closing tag
						}
						else
						{

							// If this is a closing tag for a protected element, unset the flag
							if (in_array(substr($lvalue, 1), $nobreak))
							{
								reset($innbk);
								while (list($key, $tag) = each($innbk))
								{
									if (substr($lvalue, 1) == $tag)
									{
										unset($innbk[$key]);
										break;
									}
								}
								$innbk = array_values($innbk);
							}
						}

					// Else if we're outside any tags...
					}
					else if ($value)
					{

						// If unprotected...
						if (!count($innbk))
						{

							// Use the ACK (006) ASCII symbol to replace all HTML entities temporarily
							$value = str_replace("\x06", "", $value);
							preg_match_all("/&([a-z\d]{2,7}|#\d{2,5});/i", $value, $ents);
							$value = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x06", $value);

							// Enter the line-break loop
							do
							{
								$store = $value;

								// Find the first stretch of characters over the $width limit
								if (preg_match("/^(.*?\s)?([^\s]{".$width."})(?!(".preg_quote($break, "/")."|\s))(.*)$/s{$utf8}", $value, $match))
								{

									if (strlen($match[2]))
									{
										// Determine the last "safe line-break" character within this match
										for ($x = 0, $ledge = 0; $x < strlen($lbrks); $x++) $ledge = max($ledge, strrpos($match[2], $lbrks{$x}));
										if (!$ledge) $ledge = strlen($match[2]) - 1;
										// Insert the modified string
										$value = $match[1].substr($match[2], 0, $ledge + 1).$break.substr($match[2], $ledge + 1).$match[4];
									}
								}

								// Loop while overlimit strings are still being found
							} while ($store != $value);
							// Put captured HTML entities back into the string
							foreach ($ents[0] as $ent) $value = preg_replace("/\x06/", $ent, $value, 1);
						}
					}
				}

				// Send the modified segment down the drain
				$drain .= $value;
			}

			// Return contents of the drain
			return $drain;
		}
		###############################################################################################



		/**
		* Sometimes its not possible to check calling function by putting EXIT(). e.g. in case of AJAX
		* So you can simply check by writing the content into the file
		*
		* @params string $strContent
		* @return boolean
		*
		*/
		function fnWriteFileForDebug($strContent)
		{
			// Let's make sure the file exists and is writable first.
			if (!$handle = fopen(DOCUMENT_ROOT."/usercontent/debug.txt", 'w')) {
					 fclose($handle);
					 return false;
			}
			// Write $somecontent to our opened file.
			if (fwrite($handle, $strContent) === FALSE) {
				fclose($handle);
				return false;
			}
			fclose($handle);
			return true;
		}

	  


		function fnResizeImage($strPhoto, $strClass="avatar", $strTitle="", $strId="", $strJSfunction="", $intHeight="", $intWidth="")
		{


				if($strPhoto == "images/no-photo-sm.gif"  || $strPhoto == "images/no-photo-lg.gif" || $strPhoto == "images/no-photo-big.gif" || $strPhoto == "images/no_logo.jpg")
				{
					$strNewPhoto = SITE_NAME."/themes/".$this->THEME."/".$strPhoto;
				}
				else
					$strNewPhoto = $strPhoto;



				$strTempPhoto = str_replace(SITE_NAME,"",$strPhoto);

				// If File Doesnt Exists

				if(!@file_exists(DOCUMENT_ROOT."".$strTempPhoto))
			    {
			    	$strPhoto = "images/no-photo-sm.gif";
			    }
			   if($intHeight != "" && $intWidth != "")
			   {
			   		$strGetImageSize = str_replace(SITE_NAME,DOCUMENT_ROOT,$strNewPhoto);
			   	   	$arrDimentions = clsUtil::fnSetImageHeighWidth($strGetImageSize, $intHeight, $intWidth);
					$intHeight = "height = '".$arrDimentions['height']."'";
					$intWidth = "width = '".$arrDimentions['width']."'";
			   }

			   if($strPhoto == "images/no-photo-sm.gif" || $strPhoto == "images/no-photo-big.gif")
			   {

					//$strResizeImage = "<img src='$strNewPhoto' id='$strId' class='$strClass' $intHeight $intWidth  title='$strTitle' $strJSfunction />" ;
					$strResizeImage = "<img src='$strNewPhoto' id='$strId' class='$strClass' $intHeight $intWidth  alt='$strTitle' title='$strTitle' $strJSfunction />" ;
			   }
			   else
			   {
					$strResizeImage = "<img src='$strPhoto' id='$strId' class='$strClass' $intHeight $intWidth alt='User Photo' title='$strTitle' $strJSfunction />";
			   }

		
			return $strResizeImage;
		}
  	   /**********************	NEW UTIL FILE TILL HERE *********************/

	

		/**
		 * Simple function gets first 2 paragraph of text, supports HTML or plain text.
		 *
		 * @author Onkar Tibe
		 * @param {String} $strData The string to summarize
		 * @param {Boolean} $isHTML Whether or not the string contains HTML
		 */
		function fnStringSummarize($strData, $isHTML = true)
		{
			$strResult = $strData;
			if($isHTML)
			{
				$strResult = nl2br($strResult);
				// convert line breaks/paragraphs
				$strResult = str_replace("\n", "", $strResult); // remove extra
				$strResult = str_replace("<br>", "\n", $strResult);
				$strResult = str_replace("<br/>", "\n", $strResult);
				$strResult = str_replace("<br />", "\n", $strResult);
				$strResult = str_replace("</p>", "\n\n", $strResult);

				// strip all remaining tags
				$strResult = strip_tags($strResult);
			}

			// try and return the first paragraph, if I can't, return all of it
			$arrParagraphs = explode("\n\n", trim($strResult));

			if(count($arrParagraphs) > 2)
			{
				$arrPartContainer = array(); //container array.
				$intCtr = 0;
				$intCharCount = 0;
				foreach($arrParagraphs as $intKey=>$strPartPost)
				{

					if(trim($strPartPost) == "" || trim($strPartPost) == "\n" || trim($strPartPost) == "\n\n")
					{
						continue;
					}
					else
					{
						//if($intCtr > 1) break;

						if($intCharCount > 1200) break;

						$intCharCount = $intCharCount + strlen($strPartPost);
						$arrPartContainer[] =  nl2br(trim($strPartPost));
						$intCtr++;
					}
				}

				$strTempParagraphs = implode("<br><br>", $arrPartContainer);

			}
			else
			{
				$strTempParagraphs = $strData;
			}

			return $strTempParagraphs;
		}

		/*
			This Function is for creating tiny url
		*/

		function fnCreateShortUrl($strLongUrl, $strProvider="bitly")
		{  
			///var/www/vhosts/justmeans.com/httpdocs/inc/config.inc.php
			//require_once 'zend/Json.php';
			switch($strProvider)
			{
				case "bitly":
					$strProcessedApiUrl = sprintf(BITLY_URL, urlencode($strLongUrl), BITLY_USER, BITLY_API_KEY);
					$arrValues = @file($strProcessedApiUrl); 
					/*echo "<pre>";
					print_r ($arrValues);
					die;*/ 
					if(is_array($arrValues))
					{
						if(count($arrValues))
						{
							foreach($arrValues as $intKey=>$strPartString)
							{
								$strString .= $strPartString;
							}
						}
					}
					else
					{
						return false;
					}
					
					if(trim($strString) == "")
					{
						return false;
					}
					else
					{  	
						$arrShortUrl = clsUtil::fnJM_Json_Decode(trim($strString));
						
						if(is_array($arrShortUrl))
						{ 
							if(count($arrShortUrl))
							{
								if((int)$arrShortUrl['errorCode'] == 0)
								{
								    $strShortUrl['url'] = $arrShortUrl['results'][$strLongUrl]['shortUrl'];
									$strShortUrl['hash'] = $arrShortUrl['results'][$strLongUrl]['userHash'];
									return $strShortUrl['url'];
								}
								else
								{
									return false;
								}
							}
							else
							{
								return false;
							}
						}
						else
						{ 
							return false;
						}
					}
				break;
			}

			return false;
		}
		
  }
?>