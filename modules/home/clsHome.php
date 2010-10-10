<?php
/**
* This is base class of Home Module
* @author Praxis Solutions 
* @package Home
*
*/
class clsHome extends clsParent
{
	/**
	* JUST TO USE BASE CLASS WITH OBJECT VIA FNMARMIK()
	*
	*/
	function __construct($hdlDb,$strModule = "",$strAction="")
	{
		//JUST TO USE BASE CLASS WITH OBJECT
		$this->hdlDb = $hdlDb;
		$this->strModule = $strModule;
		$this->strAction = $strAction;
	}
	 
	/**
	* This overloaded method by subclass called by name fnSetProperties()
	* @access public
	* @param string $strMethodName
	* @param array $arrParams
	*/
	public function __call($strMethodName,$arrParams)
	{
		//LOADS THE DEFAULT SETTINGS FOR MODULES
		$this->fnLoadSettings($arrParams);

		$this->LEFT_PANEL = false;
		$this->RIGHT_PANEL = true;
		$this->WINDOW_TITLE= "";
	}

	/**
	* Function fnProcessLeft Process Left panel for Global Template file
	* @access public 
	* @param object $hdlTpl
	*  	
	*/
	function fnProcessLeft($hdlTpl)
	{
		//
	}

	/**
	* Function fnProcessRight to Process Right panel for Global Template file
	* @access public 
	* @param object $hdlTpl
	*  	
	*/
	function fnProcessRight($hdlTpl)
	{
		//PROCESS CONTENT FROM RIGHT COLUMN
		$hdlRTpl = clsUtil::fnTemplateClass($this->strModule);  		
		$hdlRTpl->loadTemplateFile("_right.tpl.html",1,1);
		$hdlRTpl->setVariable("test_variable", "right");
		$strRightContent =  $hdlRTpl->get();
		
		//PRINT RIGHT COLUM HTNL CONTENT ON THE GLOBAL TPL
		$hdlTpl->touchBlock("RIGHT_COLUMN");
		$hdlTpl->setVariable("RIGHT", $strRightContent);
		$hdlTpl->parse("RIGHT_COLUMN");
	}
}
?>