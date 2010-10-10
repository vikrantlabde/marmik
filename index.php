<?php
/**
* cuePHP Content Processing file
* 
* @author Vikrant Labde <vikrant@cuelogic.co.in>
* @version 1.0
*/

session_start();

/**
* INCLUDE CONFIGURATION FILE
*/
require_once("inc/config.inc.php");

/**
* DATA BASE OBJECT
*/
$hdlDb = clsDbUtil::fnConnectDB($_ARRDSN);

/**
* VALIDATE ACTION
*/
$strAction = trim($_GET["action"]);
$strAction = ($strAction == "") ? "home" : $strAction;

/**
* BUILD CLASSNAME FROM ACTIONS ARRAY
*/
list($strModuleName,$strClassName) = explode(":",$_ARRMODULE[$strAction]["module"]);
$strModuleClass = "cls".ucfirst($strModuleName);
$strClassName = "cls".ucfirst($strClassName);

/**
* INCLUDE SECURITY CHECK
*/
require_once("inc/security.inc.php");

/**
* TEMPLATE OBJECT
*/
$hdlTpl = ((int)$_ARRMODULE[$strAction]["tpl"])?clsUtil::fnTemplateClass($strModuleName):NULL;

/**
* INCLUDE CONTROLlER CLASSES
*/
require_once DOCUMENT_ROOT."/modules/$strModuleName/$strModuleClass.php";
require_once DOCUMENT_ROOT."/modules/$strModuleName/$strClassName.php";

/**
* BUILD OBJECT FOR VIEW/TEMPLATE
*/
$hdlModule = new $strClassName($hdlDb,$hdlTpl,$strModuleName,$strAction);

/**
* RENDER HTML 
*/
print $hdlModule->PAGEDATA;

/**
* DISCARD DATABAES CONNECTION
*/
$hdlDb->disconnect();

/**
* EXPLICIT GARBAGE CONNECTION
*/
unset($hdlModule);
unset($hdlDb);
unset($hdlTpl);
?>