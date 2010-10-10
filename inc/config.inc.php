<?php
/**
* Framework level configuration 
* @author Vikrant Labde <vikrant@cuelogic.co.in>
* 
*/

//set error handler
error_reporting(E_ALL);
ini_set('display_errors', 0);

set_error_handler("customError");
//error_reporting(0);


/**
* SETTING FOR CRON FILE
*/
$strServerName = $_SERVER['SERVER_NAME'];	

/**
* Include the config.inc.php for particualr domain
*
*/
require_once "sites/".$strServerName."/config.inc.php";

/**
* PHP.INI VARIABLE: SET THE DEFAULT INCLUDE PATH
*/
ini_set("include_path", $strInludePath);
	
/**
* ADMINISTRATOR'S EMAIL
*/
define("ADMINEMAIL", $strAdminEmail);    

/**
* DOMAIN NAME 
*/
define("SITE_NAME", $strSiteName);

/**
* LOGIN ACTION NAME
*/
define("LOGIN_ACTION", $strLoginAction);

/**
* IF USER SESSIONS ARE NOT AVAILABLE THEN WHERE TO REDIRECT THE USER 
*/
define("IF_NO_LOGIN_ACTION", $strNoLoginAction); 

/**
* BASE HREF URL: IDEALLY ITS A THEME FOLDER URL 
*/
define("BASE_HREF", $strBaseHref);

/**
* SCRIPTS FOLDER PATH
*/
 define("DOCUMENT_ROOT", $strDocumentRoot); 

# PROJECT LIB
define("PROJECT_LIB", $strLibPath);
 
# IF SITE IS RUNNING ON LOCAL SERVER 
define("ISLOCAL", $boolIsLocal); 

# REWRITE URLS IF FALSE THEN NO REWRITE URL ELSE YES
define("SIMPLE_URL", $boolSimpleUrl); 

# DEFAULT DATABASE DSN
define("DRIVER", $strDbDriver);
define("DBUSER", $strDbUser);
define("DBPASSWORD", $strDbPassword);
define("DBHOST", $strDbHost);
define("DBNAME", $strDbName);
	
# GOOGLE ANALYTICS CODE
define("GOOGLE_ANALYTICS", $strGoogleAnalyticsCode);	
	
# DB Connection
$_ARRDSN = array('phptype'=>DRIVER,'username'=>DBUSER,'password'=>DBPASSWORD,'hostspec'=>DBHOST,'database'=>DBNAME);
	
# Modules Files Path
define("DIR_MODULES", DOCUMENT_ROOT."/modules");

# DEVELOPMENT MODE
define("DEVELOPMENT", $boolDevelopmentMode);

# Pear DB class file
require_once "MDB2.php";

# include the sigma template engine file
require_once 'HTML/Template/Sigma.php';

# Utility classes
require_once DOCUMENT_ROOT.'/util/clsUtil.php';   
require_once DOCUMENT_ROOT.'/util/clsDbUtil.php'; 

	
# LOAD PAGE CONTROL FILES
$intCtr = 0;
if(is_array($_INSTALLED_MODULES))
{
	$_ARRMODULE = array();
	foreach($_INSTALLED_MODULES as $intKey=>$strModuleName)
	{
		require_once(DOCUMENT_ROOT."/modules/$strModuleName/$strModuleName"."_actions.php");

		if(is_array($_ACTIONS))
		{
			foreach($_ACTIONS as $strActionKey=>$arrModuleInfo)
			{
				$_ARRMODULE[$strActionKey] = $arrModuleInfo;
			}
			unset($_ACTIONS);
		}
	}
	$strModuleName = "";
}
	
	
	
/**
* Parent class of all modules base class loads default class 
* variables and execute default functions 
*/
require_once DOCUMENT_ROOT."/util/clsParent.php";
# -- # --#


/**
* Custom error handler function  
*/
function customError($errno, $errstr, $errfile, $errline)
{

	//echo "$errno ----- $errstr ---- $errfile <br>";
	
	
	switch($errno)
	{
		case E_ERROR:
		 echo "This is E_ERROR <br>"; 
		break;
		
		case E_WARNING:
		 echo "This is E_WARNING <br>"; 
		break;
		
		case E_PARSE:
		 echo "This is E_PARSE <br>"; 
		break;
		
		case E_NOTICE:
		break;
		
		case E_CORE_ERROR:
		 echo "This is E_CORE_ERROR <br>"; 
		break;
		
		case E_CORE_WARNING:
		 echo "This is E_CORE_WARNING <br>"; 
		break;
		
		case E_COMPILE_ERROR:
		 echo "This is E_COMPILE_ERROR <br>"; 
		break;
		
		case E_COMPILE_WARNING:
		 echo "This is E_COMPILE_WARNING <br>"; 
		break;
		
		case E_USER_ERROR:
		 echo "This is E_USER_ERROR <br>"; 
		break;
		
		case E_USER_WARNING:
		 echo "This is E_USER_WARNING <br>"; 
		break;
		
		case E_USER_NOTICE:
		 echo "This is E_USER_NOTICE <br>"; 
		break;
		
		case E_STRICT:
		break;
		
		case E_RECOVERABLE_ERROR:
		 echo "This is E_RECOVERABLE_ERROR <br>"; 
		break;

	}
	
	/*if(DEVELOPMENT)
		echo "<b>Error:</b> $errno, $errstr, $errfile, $errline, <br>";
	else
		echo "We are experiencing some problems <br>";	
	*/	
}




?>