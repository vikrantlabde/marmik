<?

class clsParent
{
	
	/**
	* Database object 
	* @var object
	* @access public
	*/
	public $hdlDb;
	
	/**
	* Database object 
	* @var object
	* @access public
	*/
	public $hdlTpl;
	
	/**
	* Name of the module @example /inc/page_control.php 
	* @var string
	* @access public 
	*/
	public $strModule;
	
	/**
	* Action name @example /inc/page_control.php 
	* @var string
	* @access public
	*/
	public $strAction;
	
	/**
	* The Page HTML container
	* @var string
	* @access public
	*/
	public $PAGEDATA;
	
	/**
	* GET global variable container
	* @var array
	* @example clsUtil::fnGETParams /util/clsUtil.php
	*/
	public $G; 
	
	/**
	* POST global variable container
	* @var array
	* @access public
	* @example clsUtil::fnPOSTParams /util/clsUtil.php
	*/
	public $P; #$_POST
	
	/**
	* REQUEST global variable container
	* @var array
	* @access public
	* @example clsUtil::fnREQUESTarams /util/clsUtil.php
	*/
	
	public $R; #$_REQUEST
	
	/**
	* Name of the Global TPL file @see /theme/<themename>/
	* @access public
	* @var array
	*/
	public $GLOBALTPL;
	
	
	/**
	* will decided whether to use default left panel or not
	*
	* @var bool
	* @access public
	*/
	public $IS_DEFAULT_LEFT;
	
	/**
	* will decide whether to use default right panel or not
	*
	* @var bool
	* @access public
	*/
	public $IS_DEFAULT_RIGHT;
	
	/**
	* decide whether there's a left panel or not
	*
	* @var bool
	* @access public
	*/
	public $LEFT_PANEL;
	
	/**
	* decide whether theres a right panel or not
	*
	* @var bool
	* @access public
	*/
	public $RIGHT_PANEL;

	/**
	* decide whether theres a right panel or not
	*
	* @var bool
	* @access public
	*/
	public $GLOBAL_PANEL;
	
	
	/**
	* Name of the RELEATED ACTION used in clsUtil::fnProcessStructure function 
	* @access public
	* @var string
	*/
	public $RELATED_ACTION;
	
	/**
	* <h2>Page titme </h2>
	* @access public
	* @var string
	*/
	public $PAGE_TITLE;
	
	/**
	* Title of Window
	* @access public
	* @var string
	*/
	public $WINDOW_TITLE;
	
	/**
	* Title of Window
	* @access public
	* @var string
	*/
	public $WINDOW_SUB_TITLE;
	
	
	/**
	* ADD Page/module specific Meta Description
	* @access public
	* @var string
	*/
	public $META_DESC;
	
	
	/**
	* ADD Page/module specific Meta KeYwords
	* @access public
	* @var string
	*/
	public $META_KEYWORDS;
	
	/**
	* Control search engin robots behaviour
	* @access public
	* @var string
	*/
	public $META_ROBOTS;
	
	
	/**
	* To hide or show Header content
	* @access public
	* @var string
	*/
	public $HEADER;
	
	
	/**
	* To hide or show Footer content
	* @access public
	* @var string
	*/
	public $FOOTER;
	
	
	/**
	* To hide or show CSS code
	* @access public
	* @var string
	*/
	public $CSS;
	
	
	/**
	* To hide or show JS Code
	* @access public
	* @var string
	*/
	public $JS;
	
	
	/**
	* This variable controls the processing of the left panel
	* from other Modules 
	*
	* @access public
	* @var string
	*/
	public $GET_LEFT_FROM_OTH_MODULE;
	
	
	/**
	* This variable controls the processing of the right panel
	* from other Modules 
	*
	* @access public
	* @var string
	*/
	public $GET_RIGHT_FROM_OTH_MODULE;
	
	/**
	* This variable controls the processing of the right panel
	* from other Modules 
	*
	* @access public
	* @var string
	*/
	public $BREADCRUMB_SEPERATOR;
	
	/**
	* WHETHER PAGE HAS AUTOCOMPLETE CONTROL
	* from other Modules 
	*
	* @access public
	* @var string
	*/
	public $AUTOCOMPLETE_CONTROL;
	
	/**
	* Decides the Theme Name for Module or Particualr Action
	*
	* @access public
	* @var string
	*/
	public $THEME;


	/**
	* ADD Page/module specific Meta Description
	* @access public
	* @var string
	*/
	public $METADESCRIPTION;



	/**
	* ADD Error code 
	* @access public
	* @var array
	*/
	public $ERRORCODE;
	
	
	/**
	* To Set Char display limit 
	* @access public
	* @var array
	*/
	public $strCharLimit;
	
	
	/**
	* To Set Company selected menu and submenu 
	* @access public
	* @var array
	*/
	public $COMPANYSELCTEDMENU;
	
	
	public $COMPANYSELCTEDSUBMENU;

	public $INBOUND;
	
	
	// OVERLOADED METHOD
	protected function fnLoadSettings($arrParams)
	{
		$this->hdlDb = $arrParams[0];
		$this->hdlTpl = $arrParams[1];
		$this->strModule = $arrParams[2];
		$this->strAction = $arrParams[3];
		$this->G = clsUtil::fnGETParams(); //FILTER VALUES FROM GET
		$this->P = clsUtil::fnPOSTParams(); //FILTER VALUES FROM POST
		$this->R = clsUtil::fnREQUESTParams();
		
		
		# LOAD TEMPLATE FILE
        if(!is_null($this->hdlTpl))
        {
            $this->hdlTpl->loadTemplateFile($this->strAction.".tpl.html",1,1);
        }   
       
    	//SEO MANAGEMENT
		$this->META_DESC = '';
		$this->META_KEYWORDS = '';
		$this->META_ROBOTS = ''; //INDEX,FOLLOW
		
		//LAYOUT MANAGEMENT
		$this->CSS = true;
		$this->JS = true;
		
		$this->GLOBALTPL = "_global";
		
		
		//LEFT n RIGHT PANEL MANAGEMENT
		$this->LEFT_PANEL = false;
		$this->RIGHT_PANEL = false;
		$this->GLOBAL_PANEL = false;
		
		$this->IS_DEFAULT_LEFT = false;
		$this->IS_DEFAULT_RIGHT = false;
		
		$this->GET_LEFT_FROM_OTH_MODULE = ""; //GET LEFT PPANEL FROM OTHER MODULE
		$this->GET_RIGHT_FROM_OTH_MODULE = ""; //GET RIGHT PANEL FROM OTHER MODULE
		
		$this->BREADCRUMB_SEPERATOR = " > ";
		$this->THEME = "default";
	
	}	
}

?>