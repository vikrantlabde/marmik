
	// Email Validation Javascript
	
	function fnEmailCheck(addr, man, db) {
		if (addr == '' && man) {
			if (db) alert('email address is mandatory');
			return false;
		}
		if (addr == '') return true;
		var invalidChars = '\/\'\\ ";:?!()[]\{\}^|';
		for (i=0; i<invalidChars.length; i++) {
			if (addr.indexOf(invalidChars.charAt(i),0) > -1) {
				if (db) alert('email address contains invalid characters');
				return false;
			}
		}
			
		for (i=0; i<addr.length; i++) {
			if (addr.charCodeAt(i)>127) {
				if (db) alert("email address contains non ascii characters.");
				return false;
			}
		}
	
		var atPos = addr.indexOf('@',0);
		if (atPos == -1) {
			if (db) alert('email address must contain an @');
			return false;
		}
		if (atPos == 0) {
			if (db) alert('email address must not start with @');
			return false;
		}
		if (addr.indexOf('@', atPos + 1) > - 1) {
			if (db) alert('email address must contain only one @');
			return false;
		}
		if (addr.indexOf('.', atPos) == -1) {
			if (db) alert('email address must contain a period in the domain name');
			return false;
		}
		if (addr.indexOf('@.',0) != -1) {
			if (db) alert('period must not immediately follow @ in email address');
			return false;
		}
		if (addr.indexOf('.@',0) != -1){
			if (db) alert('period must not immediately precede @ in email address');
			return false;
		}
		if (addr.indexOf('..',0) != -1) {
			if (db) alert('two periods must not be adjacent in email address');
			return false;
		}
		
		var suffix = addr.substring(addr.lastIndexOf('.')+1);
		
		if (suffix.length != 2 && suffix != 'com' && suffix != 'net' && suffix != 'org' && suffix != 'edu' && suffix != 'int' && suffix != 'mil' && suffix != 'gov' & suffix != 'arpa' && suffix != 'biz' && suffix != 'aero' && suffix != 'name' && suffix != 'coop' && suffix != 'info' && suffix != 'pro' && suffix != 'museum') {
			if (db) alert('invalid primary domain in email address');
			return false;
		}
		return true;
	}

	/*
	Author: Pathfinder Solutions, India
	Desc: The Form validation script for any type of form
	*/

	function fnEmailCheck_old (emailStr) {
	var emailPat=/^(.+)@(.+)$/
	
	var specialChars="\\(\\)<>@,;:~^\\\\\\\"\\.\\[\\]"
	
	var validChars="\[^\\s" + specialChars + "\]"
	
	var quotedUser="(\"[^\"]*\")"
	
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
	
	var atom=validChars + '+'
	
	var word="(" + atom + "|" + quotedUser + ")"
	
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
	
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
	
	
	var matchArray=emailStr.match(emailPat)
	if (matchArray==null) 
	 {
		 //alert("Email address seems incorrect (check @ and .'s)") // VIKRNT
	 	 return false
	 }
	var user=matchArray[1]
	var domain=matchArray[2]
	
	// See if "user" is valid
	if (user.match(userPat)==null) {
		// user is not valid
		//alert("The username doesn't seem to be valid.") // VIKRANT
		return false
	}
	
	/* if the e-mail address is at an IP address (as opposed to a symbolic
	   host name) make sure the IP address is valid. */
	var IPArray=domain.match(ipDomainPat)
	if (IPArray!=null) {
		// this is an IP address
	   for (var i=1;i<=4;i++) {
		 if (IPArray[i]>255) {
			 //alert("Destination IP address is invalid!") // VIKRANT
	  return false
		 }
		}
		return true
	}
	
	// Domain is symbolic name
	var domainArray=domain.match(domainPat)
	if (domainArray==null) {
	 //alert("The domain name doesn't seem to be valid.") // VIKRANT
		return false
	}
	
	var atomPat=new RegExp(atom,"g")
	var domArr=domain.match(atomPat)
	var len=domArr.length
	if (domArr[domArr.length-1].length<2 ||
		domArr[domArr.length-1].length>4) {
	   // the address must end in a two letter or three letter word.
	   //alert("The address must end in a three-letter domain, or two letter country.") //VIKRANT
	   return false
	}
	
	// Make sure there's a host name preceding the domain.
	if (len<2) {
	   var errStr="This address is missing a hostname!"
	   //alert(errStr) // VIKRANT
	   return false
	}
	// If we've got this far, everything's valid!
	return true;
	}
	
	function validateUSDate(strValue)
	{
		var objRegExp = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
		
		//check to see if in correct format
		if(!objRegExp.test(strValue))
			return false; //doesn't match pattern, bad date
		else
		{
			var strSeparator = strValue.substring(2,3) 
			
			var arrayDate = strValue.split(strSeparator); 
			//create a lookup for months not equal to Feb.
			var arrayLookup = { '01' : 31,'03' : 31, 
								'04' : 30,'05' : 31,
								'06' : 30,'07' : 31,
								'08' : 31,'09' : 30,
								'10' : 31,'11' : 30,'12' : 31}
			var intDay = parseInt(arrayDate[1],10); 
		
			//check if month value and day value agree
			alert("dada"+arrayLookup[arrayDate[0]]);
			if(arrayLookup[arrayDate[0]] != null)
			{
			  if(intDay <= arrayLookup[arrayDate[0]] && intDay != 0)
				return true; //found in lookup table, good date
			}
		
			//check for February (bugfix 20050322)
			//bugfix  for parseInt kevin
			//bugfix  biss year  O.Jp Voutat
			var intMonth = parseInt(arrayDate[0],10);
			if (intMonth == 2)
			{ 
				var intYear = parseInt(arrayDate[2]);
				if (intDay > 0 && intDay < 29)
				{
					return true;
				}
				else if (intDay == 29)
				{
					if ((intYear % 4 == 0) && (intYear % 100 != 0) || (intYear % 400 == 0))
					{
						// year div by 4 and ((not div by 100) or div by 400) ->ok
						return true;
					}   
				}
			}
		}  
		return false; //any other values, bad date
	}
	function ValidateCurrency(str)
	{
		if (str <= 0)
			return false;
		return /^[$]?\d{1,10}(\.\d{1,4})?$/.test(str);
	}
	function fnValidatePhone(strPhoneNumber)
	{
		var objRegExp  = /^\([1-9]\d{2}\)\s?\d{3}\-\d{4}$/
        var validPhone = objRegExp.test(strPhoneNumber);
        if (!validPhone)
        {
          return false;
        }
		return true;
	}
	
	function fnValidateUNString(string)
	{
		var strLen = string.length
		var iUNChars = "~`^_=+!*|,\":<>[]{}`\';()@&$#%-[1-9]";
		for (var i = 0; i < strLen; i++) 
		{
			if (iUNChars.indexOf(string.charAt(i)) != -1) 
			{
				return false;
			}
		}
		return true;
	}

	function fnValidateNotChar(string)
	{
		var objString = "[a-zA-Z]";
		var strLen = string.length
		for (var i = 0; i < strLen; i++) 
		{
			if (string.charAt(i).match(objString)) 
			{
				return false;
			}
		}
		return true;
		/*var strLen = string.length
		var iUNChars = "~`^_=+!*|,\":<>[]{}`\';()@&$#%-[1-9]";
		for (var i = 0; i < strLen; i++) 
		{
			if (iUNChars.indexOf(string.charAt(i)) != -1) 
			{
				return false;
			}
		}
		return true;*/
	}
	
	function fnValidateString(string)
	{
		var strLen = string.length
		var iChars = "*!|,.\":<>[]{}`\';()@&$#%_-~^+?/=\\";
		for (var i = 0; i < strLen; i++) 
		{
			if (iChars.indexOf(string.charAt(i)) != -1) 
			{
				return false;
			}
		}
		if (string != "")
		{
			var pattern =new RegExp(/\d/);
			if (pattern.test(string))
				return false;
		}
		return true;
	}
	
	function fnValidateSpecialChar(string)
	{
		var iChars = /[`_\-~!@#$%&,.:;<>{}()=\/\"\/\*\/\^\/\+\/\|\/\/]/
        var SpecialChar = iChars.test(string);
		if (SpecialChar) 
		{
			return false;
		}
		return true;
	}
	
	function fnVlidateCompanyName(string)
	{
		var iChars = /[`~!@#$%&,:;<>=\/\"\/\*\/\^\/\+\/\|\/\/]/
        var SpecialChar = iChars.test(string);
		if (SpecialChar) 
		{
			return false;
		}
		return true;
	}
	
	function fnValidateChatId(string)
	{
		var iChars = /[`\~!@#$%&,:;<>{}()=\/\"\/\*\/\^\/\+\/\|\/\/]/
        var SpecialChar = iChars.test(string);
		if (SpecialChar) 
		{
			return false;
		}
		return true;
	}
	
	function fnValidatePhoneNo(phone)
	{
		strNumVal = ((/[0-9]/.test(phone)));
		strCharVal = ((/[a-zA-Z]/.test(phone)));
		strInvalideChar = ((/[`_~!@#$%&,.:;<>{}=\/\"\/\*\/\^\/\+\/\|\/\/]/.test(phone)));
		
		if( strCharVal == true || strInvalideChar == true)
		{
			return false;
		}
		if( strNumVal == true)
		{
			return true;
		}
		return false;
	}
	
	///added by prachi for name validation
	function fnValidateName(string)
	{
		strNumVal = ((/[0-9]/.test(string)));
		strCharVal = ((/[a-zA-Z]/.test(string)));
		strInvalideChar = ((/[`_~!@#$%&,.:;<>{}=\/\"\/\*\/\^\/\+\/\|\/\/]/.test(string)));
		
		if( strNumVal == true || strInvalideChar == true)
		{
			return false;
		}
		if( strCharVal == true)
		{
			return true;
		}
		return false;
	}
	///added by prachi for name validation ends
	
	function trim(stringToTrim) 
	{
		return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	
	function fnIsNumber(intNumber)
	{
		if(isNaN(intNumber) == true)	
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	//  End -->
	
	/*
	FUNCTION: fnValidateInput
	PARAMS: form, input type
	*/
	function fnValidateInputType(theElement, strType)
	{
		var theForm = theElement, z = 0;
		var intChkCount = 0;
		for(z=0; z<theForm.length;z++)
		{
			if(theForm[z].type == strType)
			{
				switch (strType)
				{
					case "radio": if (theForm[z].checked == true)
								  {
									  intChkCount = intChkCount+1;
								  }
								  break;

					case "checkbox":  if (theForm[z].checked == true)
									  {
										  intChkCount = intChkCount+1;
									  }
									  break;
				}
			}
		  }
		  return intChkCount;
	}

	
	
	var lightbox = 1;
	var showerrorinlable = 0;
	var errordiv = "";
	var boolShowErrorTitle = true;
	var boolReturnError = 0;
	var strFormId = "";
	function fnValidateForm(obj)
	{ 
		var frm = obj;
		var len = frm.elements.length;
		var errormsg = "";
		var errormsgTitle = "Required Fields:";
		
		var arrErrorMessages = Array();
		
		var noserrors = 0
		
		if(lightbox == 1)
		{
			var msgimage = "<img src='images/error_small.jpg' alt='error' border='0' align='absmiddle'  /> ";
			var linebreak = "<br />";
		}
		else if(errordiv != "")
		{
			var msgimage = "";
			var linebreak = "<br />";
		}
		else if (showerrorinlable == 1)
		{
			var msgimage = "";
			var linebreak = "";
		}
		else
		{
			var msgimage = "";
			var linebreak = "\n";
		}
		
		for(var i=0 ; i<len ; i++) 
		{		
			var eletype = frm.elements[i].type;
			if( (eletype.toLowerCase() != "submit") && (eletype.toLowerCase() != "hidden"))
			{
				if (showerrorinlable == 0)
					frm.elements[i].className = "";
					
				if(frm.elements[i].alt != "");
				{
					var arrValue = new Array();
					
					try
					{
						var strValue = "";
						if(frm.elements[i].type == 'textarea')
						{
							strValue = frm.elements[i].title;
						}
						else
						{
							strValue = frm.elements[i].alt;
						}
						
						if(frm.elements[i].type == 'select-one')
						{
							strValue = frm.elements[i].title;
						}
						
						if(frm.elements[i].type == 'select-multiple')
						{
							strValue = frm.elements[i].title;
						}

						var eleValue =  trim(frm.elements[i].value);

						if(frm.elements[i].type == 'checkbox')
						{
							eleValue = frm.elements[i].checked;
						}
						
						if(frm.elements[i].type == 'radio')
						{
							eleValue = frm.elements[i].checked;
						}
						
						arrValue = strValue.split(/:/);
						var vallength = arrValue.length
						if(vallength > 0)
						{
							for(var j=0 ; j<vallength ; j++) 
							{
								//alert(arrValue[j]);
								var formula = trim(arrValue[j]);
								var arrFormula = formula.split("-");
								
								if(arrFormula[0] == "FILE") // FILE FIELD VALIDATION added on 08-08-09 by amol
								{
									 if(eleValue == "")
									 {
										 arrErrorMessages[noserrors] = arrFormula[1];
									  	 //errormsg = errormsg +  linebreak + arrFormula[1];
									  	 noserrors++;
									 }
								}
								
								if(arrFormula[0] == "M") // MANDATORY FIELD VALIDATION
								{
									if(eleValue == "")
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = "inputerror";
										}
										noserrors++;
									}
								}	
								
								if(arrFormula[0] == "E") // EMAIL VALIDATION
								{
									if(eleValue != "")
									{
										if(!fnEmailCheck(eleValue))
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}	
								
								if(arrFormula[0] == "CHAR") // EMAIL VALIDATION
								{
									if(eleValue != "")
									{
										if(!fnValidateString(eleValue))
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}
								
								///added by prachi for name validation
								if(arrFormula[0] == "NAME") // NAME VALIDATION
								{
									if(eleValue != "")
									{
										if(!fnValidateName(eleValue))
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}
								
								if(arrFormula[0] == "NOTCHAR") // EMAIL VALIDATION
								{
									if(eleValue != "")
									{
										if(!fnValidateNotChar(eleValue))
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}//

								if(arrFormula[0] == "PH") // PHONE VALIDATION
								{
									if(eleValue != "")
									{
										if(!fnValidatePhoneNo(eleValue))
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}

								if(arrFormula[0] == "SEL") // SELECT BOX VALIDATION
								{
									if(eleValue != "")
									{
										if(eleValue == "")
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}	

								if(arrFormula[0] == "CHK") // CHECK BOX FIELD VALIDATION
								{
									if(eleValue == false)
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}	

								if(arrFormula[0] == "RDO") // CHECK BOX FIELD VALIDATION
								{
									if(eleValue == false)
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}	

								if(arrFormula[0] == "NUM") // MANDATORY FIELD VALIDATION
								{
									if(eleValue != "")
									{
										if(!fnIsNumber(eleValue))
										{
											arrErrorMessages[noserrors] = arrFormula[1];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}	
								
								if(arrFormula[0] == "MIN") // MINIMUM LIMIT
								{
									if(eleValue != "")
									{
										var string = eleValue;
										var limit = string.length;
										if(limit < parseInt(arrFormula[1]))
										{
											arrErrorMessages[noserrors] = arrFormula[2];
											if (showerrorinlable)
											{
												strElementId = frm.elements[i].id;
												document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[2]+"</label>";
											}
											else
											{
												frm.elements[i].className = 'inputerror';
											}
											noserrors++;
										}
									}
								}
								
								if(arrFormula[0] == "MAX") // MAXIMUM LIMIT
								{
									var string = eleValue;
									var limit = string.length;
									if(limit > parseInt(arrFormula[1]))
									{
										arrErrorMessages[noserrors] = arrFormula[2];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[2]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								//
								if(arrFormula[0] == "BET") // BETWEEN LIMIT
								{
									var string = eleValue;
									var limit = string.length;
									if(limit < parseInt(arrFormula[1]) && limit > parseInt(arrFormula[2]))
									{
										arrErrorMessages[noserrors] = arrFormula[3];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[3]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								
								if(arrFormula[0] == "COMPANYNAME") // BETWEEN LIMIT
								{
									if(!fnVlidateCompanyName(eleValue))
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								
								if(arrFormula[0] == "COMP") // COMPARISION BETWEEN TWO FIELDS
								{
									var compvalue = trim(document.getElementById(arrFormula[2]).value)
									if(compvalue)
									{
										if(arrFormula[1] == "==")
										{
											if(eleValue != compvalue)
											{
												arrErrorMessages[noserrors] = arrFormula[3];
												if (showerrorinlable)
												{
													strElementId = frm.elements[i].id;
													document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[3]+"</label>";
												}
												else
												{
													frm.elements[i].className = 'inputerror';
												}
												noserrors++;
											}
										}
										if(arrFormula[1] == "!=")
										{
											if(eleValue == compvalue)
											{
												arrErrorMessages[noserrors] = arrFormula[3];
												if (showerrorinlable)
												{
													strElementId = frm.elements[i].id;
													document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[3]+"</label>";
												}
												else
												{
													frm.elements[i].className = 'inputerror';
												}
												noserrors++;
											}
										}
									}
								}//
								
								if(arrFormula[0] == "CMPVALUE") // DUPLICATE VALIDATION
								{
									if(arrFormula[1] != eleValue)
									{
										arrErrorMessages[noserrors] = arrFormula[2];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[2]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								if(arrFormula[0] == "MAXNUM") // DUPLICATE VALIDATION
								{
									if(eleValue < arrFormula[1])
									{
										arrErrorMessages[noserrors] = arrFormula[2];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[2]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								
								if(arrFormula[0] == "CURR") // DUPLICATE VALIDATION
								{
									if(!ValidateCurrency(eleValue))
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								
								if(arrFormula[0] == "COMPOR") //COMPAIR TWO FIELDS
								{
									if(document.getElementById(arrFormula[1]).value != "" && document.getElementById(arrFormula[2]).value != "")
									{
										arrErrorMessages[noserrors] = arrFormula[3];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[3]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
									if(document.getElementById(arrFormula[1]).value == "" && document.getElementById(arrFormula[2]).value == "")
									{
										arrErrorMessages[noserrors] = arrFormula[3];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[3]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								
								if(arrFormula[0] == "DEPEND") //COMPAIR TWO FIELDS
								{
									if(eleValue != "" && document.getElementById(arrFormula[1]).value == "")
									{
										arrErrorMessages[noserrors] = arrFormula[2];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[2]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								if(arrFormula[0] == "INPUTFIELD") //VALIDATE FIELD TYPE
								{
									if(fnValidateInputType(obj, arrFormula[1]) == 0)
									{
										arrErrorMessages[noserrors] = arrFormula[2];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[2]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								if(arrFormula[0] == "SPECHAR") //VALIDATE FIELD TYPE
								{
									if(!fnValidateSpecialChar(eleValue))
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								if(arrFormula[0] == "CHATID") //VALIDATE FIELD TYPE
								{
									if(!fnValidateChatId(eleValue))
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
								if(arrFormula[0] == "URL") //VALIDATE FIELD TYPE
								{
									if(!fnValidateUrl(eleValue) && eleValue != "")
									{
										arrErrorMessages[noserrors] = arrFormula[1];
										if (showerrorinlable)
										{
											strElementId = frm.elements[i].id;
											document.getElementById(strElementId+"Err").innerHTML = "<label style='color: #FF0000;'>"+arrFormula[1]+"</label>";
										}
										else
										{
											frm.elements[i].className = 'inputerror';
										}
										noserrors++;
									}
								}
							}//
						}
					}
					catch(e)
					{ 
						//
					}
				}	
			}					 
		}
		
		for(var i=0 ; i < noserrors ; i++) 
		{
			if (errormsg == "")
				errormsg = msgimage + arrErrorMessages[i];
			else
				errormsg = errormsg + linebreak + msgimage + arrErrorMessages[i];
		}
		
		if (showerrorinlable && errormsg != "")
			return false;
		
		if(errormsg == "") 
		{
			try{
				document.getElementById(errordiv).innerHTML = "";
			}
			catch(e)
			{
				try{
				window.frames[0].document.getElementById(errordiv).innerHTML = "";
				}
				catch(c)
				{}
			}
			return true;			
		}
		else 
		{ 
			var errorTitle = "";
			if(lightbox == 1) errorTitle = "<b>Required Fields:</b><br/>";
			
			if (boolShowErrorTitle == true)
				errormsg = errorTitle + errormsg;
			
			if(boolReturnError==1)
			{ 
				return errormsg;
			}
			else
			{
				if(lightbox == 1)	
				{
					fnLightBoxError(errormsg, noserrors, errordiv);
				}
				else
				{
					alert(errormsg);	
				}
			}
			return false;
		}
		
	}

function fnLightBoxError(errormsg, noserrors, errordiv)
{
	var lightheight = 175;
	var forheight = 0;
	if(noserrors > 3)
	{
		forheight = (noserrors - 3);
		subheight = (25 * forheight);
		lightheight = lightheight + subheight;
	}
	
	if (errordiv == "")
	{
		var warning = "";
		var warning = "<div id='errormessage'><img src='images/warning_small.jpg' alt='warning' border='0' align='absmiddle'  /><br />";
		warning =  warning + errormsg;
		warning = warning + "</div>";
		
		warning = warning + "<br /><center><input type='button' value='Ok' class='commit' style='width:40px;' onclick='Lightbox.hideBox();' /></center></div>";
		Lightbox.showBoxString(warning,350);
	}
	else
	{
		var warning = "";
		// align='left' added by ANAND.
		warning = "<div class='errormessage' align='left'>";
		warning =  warning + errormsg;
		warning = warning + "</div>";
		
		try{
			
			document.getElementById(errordiv).innerHTML = warning;
			document.getElementById(errordiv).className = "";
		}
		catch(e)
		{
			try{
				
			window.frames[0].document.getElementById(errordiv).innerHTML = warning;
			window.frames[0].document.getElementById(errordiv).className = "";
			}
			catch(c)
			{
				try{
					var iframeEl = document.getElementById(strFormId);
					if ( iframeEl.contentDocument ) 
					{ // DOM
						objFormId = iframeEl.contentDocument.getElementById(errordiv);
					} 
					else if ( iframeEl.contentWindow ) 
					{ // IE win
						objFormId = iframeEl.contentWindow.document.getElementById(errordiv);
					}
					objFormId.innerHTML = warning;
				}
				catch(i) { }
			}
		}
	}
}

function fnValidateUrl(strUrl)
{
     var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]/
     if(tomatch.test(strUrl))
     {
         return true;
     }
     else
     {
         return false; 
     }
}

