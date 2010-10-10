<?php
/**
* This is security file, which checks the user sessions
* @author Vikrant Labde <vikrnat@cuelogic.co.in>
*
*/

$boolLoginStatus = (int)$_ARRMODULE[$strAction]["login"];

if($boolLoginStatus && !(int)$_SESSION['LOGINFLAG'])
{
	header("Location:".SITE_NAME."/".IF_NO_LOGIN_ACTION);	
}

?>