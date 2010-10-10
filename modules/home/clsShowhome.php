<?php
/**
* Page To Display Homepage
* This class handles  Homepage Module.
* @author Praxis Solutions
* @see clsHome
* @package Home
*
*/
class clsShowhome extends clsHome
{
	/**
	* This is constructor of the class clsHome
	*
	* @param object $hdlDb
	* @param object $hdlTpl
	* @param string $strModule
	* @param string $strAction
	*
	*/
	function __construct($hdlDb,$hdlTpl,$strModule,$strAction)
	{
		if(!is_null($strAction))
		{
			/**
			* @see __call()
			*
			*/
			$this->fnSetProperties($hdlDb,$hdlTpl,$strModule,$strAction);
			/**
			* @see fnHandleAction
			*
			*/
			$this->fnHandleAction();
		}
		else
		{
			$this->hdlDb = $hdlDb;
			$this->strModule = $strModule;
		}
	}
	/**
	*
	* This function handle all actions directed to this class and call appropriate function to process particular action
	* Each action function name is has following common code
	*
	*/
	function fnHandleAction()
	{
		switch($this->strAction)
		{
			case "home":
				$this->GLOBALTPL = "_global";
				$this->LEFT_PANEL = false;
				$this->RIGHT_PANEL = true;
				$this->WINDOW_TITLE="Cuelogic Marmik";
				$this->METADESCRIPTION = "";
				$this->META_KEYWORDS = "";
				$this->PAGEDATA = $this->_fnHome();
			break;
		}
	}

	/**
	* Function fnRSSUpdates to Update Rss
	* @uses clsUtil::fnMarmik Uses fnGetProfilePhotoofUser function of user package to Get Profile Photo of User
	* @access public
	* @param string $strQue
	* @return array
	*/
	function _fnHome()
	{
		$strGetJsString = clsUtil::fnGetJsSrcString($this->strAction);
		$arrContent['JS'] = $strGetJsString;
		$arrContent['CONTENT'] = $this->hdlTpl->get();
		return clsUtil::fnProcessStructure($arrContent);
	}

	/**
	* Function __destruct destructor of class
	*/
	function __destruct()
	{
		$this->hdlDb;
		$this->hdlTpl;
		$this->strAction;
		$this->PAGEDATA;
	}
}
?>