<?php
  
 /**
  * 
  * This file has all databae abstraction layer function 
  * we are using PEAR MDB2 for database layer
  * 
  * @author Praxis Solutions 
  * 
  */
 
  class clsDbUtil
  {
  	 /**
  	  * Function fnConnectDB to connect database.Connection of the Database called on index.php 
  	  *
  	  * @param array @arrDSN @see /inc/config.inc.php
  	  * @return object $hdlDb
  	  */
      static function fnConnectDB($arrDSN)
      {
        # create an object of Database
        $hdlDb =& MDB2::factory($arrDSN);
        if (PEAR::isError($hdlDb))
        {
            die($hdlDb->getMessage());
        }       
        return $hdlDb;
      }
	  
     /**
  	  * Function fnGetLastInsertedId returns the lasted inserted row in table.Connection of the Database called on index.php 
  	  *
  	  * @param object $hdlDb
  	  * @return int
  	  */	
  	  function fnGetLastInsertedId()
	  {
			return $this->hdlDb->queryOne("SELECT LAST_INSERT_ID() as insertid");
	  }
	  
	  /**
	   * Function fnInsert construct the Database insert query using array.
	   *
	   * @param string $strTable
	   * @param array $arrFieldsValues
	   * @param string $strFile
	   * @param string $strFunction
	   * @param string $strLine
	   * @return bool 
	   */

	  function fnInsert($strTable,$arrFieldsValues=array(), $strFile="", $strFunction = "", $strLine="")
	  {	
	  		global $QPrint;
			 global $NOHTML;
	  		if(trim($strTable) != "")
			{
				if(is_array($arrFieldsValues))
				{
					if(count($arrFieldsValues))
					{		
						$arrFields = array();
						$arrValues = array();	
						foreach($arrFieldsValues as $strField=>$strValue)	
						{
							if(is_numeric($strField)) die("clsDBUtil:fnInsert - Field Name can't be number <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
							
							$arrFields[] = trim($strField);
							if($NOHTML == 1)
							{
								$arrValues[] = addslashes(trim($strValue));
								$NOHTML = 0;
							}
							else
							{
								$arrValues[] = addslashes(trim(htmlspecialchars($strValue)));
							}
						}

						if(count($arrFields) == count($arrValues))
						{
							$strFields = implode("`,`",$arrFields);
							$strValues = implode("','",$arrValues);
						 	$strInsert = "INSERT INTO $strTable(`$strFields`) VALUES ('$strValues')";
							//print $strInsert;
							//exit();
							if($QPrint == 1) print $strInsert ."<br />";
							$valInsert = $this->hdlDb->exec($strInsert);
							if (PEAR::isError($valInsert))
							{
								die($valInsert->getMessage(). "<br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
							}
							
							$QPrint = 0;
							
							return true;
						}
						else
						{
							die("clsDBUtil:fnInsert - Column Values mismatch - <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
						}
					}
					else
					{
						die("clsDBUtil:fnInsert - Array Empty <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
					}
				}
				else
				{
					die("clsDBUtil:fnInsert - Not an Array <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
				}
			}	
			else
			{
				die("clsDBUtil:fnInsert - Frist Parameter should be Table name <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
			}				
	  }  
	  
	  /**
	   * Function fnUpdate construct the Database update query using array
	   *
	   * @param string $strTable
	   * @param array $arrFieldsValues
	   * @param string $strWhere
	   * @param string $strFile
	   * @param string $strFunction
	   * @param string $strLine
	   * @return bool
	   */
      function fnUpdate($strTable,$arrFieldsValues=array(), $strWhere="", $strFile="", $strFunction = "", $strLine="")
	  {	
	  		global $QPrint;
			global $NOHTML;
	  		if(trim($strTable) != "")
			{
				if(is_array($arrFieldsValues))
				{
					if(count($arrFieldsValues))
					{		
						$arrUpdate = array();
						foreach($arrFieldsValues as $strField=>$strValue)	
						{
							if($NOHTML == 1)
							{
								$arrUpdate[] = "$strField='".addslashes(trim($strValue))."'";
							}
							else
							{
								$arrUpdate[] = "$strField='".addslashes(trim(htmlspecialchars($strValue)))."'";
							}
						}
						$NOHTML = 0;


						$strUpdateParam = implode(",",$arrUpdate);
						
						if($strWhere != "")
							$strUpdate = "UPDATE $strTable SET $strUpdateParam WHERE $strWhere";
						else
							$strUpdate = "UPDATE $strTable SET $strUpdateParam";
						//echo $strUpdate;exit;
						if($QPrint == 1) print $strUpdate ."<br />";
						
						$valInsert = $this->hdlDb->exec($strUpdate);
						if (PEAR::isError($valInsert))
						{
							die($valInsert->getMessage(). "<br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
						}
						
						$QPrint = 0;
						
						return true;
					}
					else
					{
						die("clsDBUtil:fnUpdate - Array Empty <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
					}
				}
				else
				{
					die("clsDBUtil:fnUpdate - Not an Array <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
				}
			}	
			else
			{
				die("clsDBUtil:fnUpdate - Frist Parameter should be Table name <br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
			}				
	    } 
	  
	    /**
	     * Function fnSelect to select row from database table. 
	     *
	     * @param string $strQuery
	     * @param string $strFile
	     * @param string $strFunction
	     * @param string $strLine
	     * @return bool
	     */
		function fnSelect($strQuery,$strFile="", $strFunction = "", $strLine="")
		{	
			global $QPrint;

			if($QPrint == 1) print $strQuery ."<br />";
			/*print "<pre>";
			print_r($this->hdlDb);
			print "</pre>";*/
			$arrResult = $this->hdlDb->queryAll($strQuery,null,2); 
			//echo "<pre>";print_r($arrResult);exit;
			if (PEAR::isError($arrResult))
			{
				die($arrResult->getMessage(). "<br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
			}			
			$QPrint = 0;
			
			if(is_array($arrResult))
			{ 
				if(count($arrResult))
				{ 
					return $arrResult;
				}
				else 
				{
					//return false;				
					return array();
				}
			}
			else 
			{
				//return false;
				return array();
			}
			echo "<pre>";
			print_r ($arrResult);
			return $arrResult;

		}
		
		/**
	     * Function fnSelectOne for fetching only one record from database table
	     *
	     * @param string $strQuery
	     * @param string $strFile
	     * @param string $strFunction
	     * @param string $strLine
	     * @return mixed
	     */
		function fnSelectOne($strQuery,$strFile="", $strFunction = "", $strLine="")
		{ 
		//	print $strQuery;
			global $QPrint;
			if($QPrint == 1) print $strQuery ."<br />";
			$varResult = $this->hdlDb->queryOne($strQuery); 
			if (PEAR::isError($varResult))
			{
				die($varResult->getMessage(). "<br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
			}			
			$QPrint = 0;
			return $varResult;
		}
		
		/**
	     * function fnDelete to delete rows from the database table
	     *
	     * @param string $strQuery
	     * @param string $strFile
	     * @param string $strFunction
	     * @param string $strLine
	     * @return bool
	     */
		function fnDelete($strQuery,$strFile="", $strFunction = "", $strLine="")
		{
			global $QPrint;
			if($QPrint == 1) print $strQuery ."<br />";
			$valDelete = $this->hdlDb->exec($strQuery);
			if (PEAR::isError($valDelete))
			{
				die($valDelete->getMessage(). "<br>Calling File:$strFile  <br> Calling Method:$strFunction <br>Line: $strLine");
			}
			
			$QPrint = 0;
			return true;
			
		}

		/**
		* Function fnExecQuery to execute the routine
		*
		* @param string $strQuery
		* @param string $strFile
		* @param string $strFunction
		* @param string $strLine
		*/
		function fnExecQuery($strQuery,$strFile="", $strFunction = "", $strLine="")
		{
			$valInsert = $this->hdlDb->exec($strQuery);
			if (PEAR::isError($valInsert))
			{
				die($valInsert->getMessage(). "<br>Calling File:$strFile <br> Calling Method:$strFunction <br>Line: $strLine");
			}
		}
		/**
		* Function returns the total row count
		* 
		* @param string $strQuery
		* @return int
		*
		*/

		function fnGetNumberRows($strQuery,$strFile="", $strFunction = "", $strLine="")
	    {
			$DB = mysql_connect(DBHOST, DBUSER, DBPASSWORD);
			mysql_select_db(DBNAME, $DB);
			$RES = mysql_query($strQuery, $DB);
			if(!$RES) die(mysql_error(). "<br>Calling File:$strFile <br> Calling Method:$strFunction <br>Line: $strLine");

			$intRowCount = mysql_num_rows($RES);
			mysql_close($DB);
			unset($DB);
			return $intRowCount;
		}
  }
 ?>