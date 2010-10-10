<?php
/*
* 
* This file has configuration information of site localhost
* @author Praxis Solutions 
* 
*/
$strInludePath = ".;C:/Program Files/xampp/htdocs/marmik/lib/pear";
$strLibPath = "C:/Program Files/xampp/htdocs/marmik//lib/pear";
$strSiteName = "http://localhost/marmik";
$strBaseHref = "http://localhost/marmik";
$strDocumentRoot = "C:/Program Files/xampp/htdocs/marmik";

/**
*
*/
$strDbDriver = "mysqli";
$strDbUser = "root";
$strDbPassword = "";
$strDbHost = "localhost";
$strDbName = "test";

$boolSimpleUrl = false;

$boolIsLocal = 1;

$strThemes= "default";

$strHomepageAction= "home";
$strLoginAction = "login";
$strNoLoginAction = "login";

$boolDevelopmentMode = false;

$strAdminEmail = "vikrant@cuelogic.co.in";


/**
Google analytics code
*/
$strGoogleAnalyticsCode = "";

/**
* INSTALLED MADULES
* Add name of the module folder in below array if you want that module accessible for users to use
*/

# SET REQUEST_URI IN SESSION ID
$_INSTALLED_MODULES = array(
								"home"
							);

?>