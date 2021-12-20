
function FilterData()
{
	var frmdate = document.getElementById('frmdate').value;
	var todate = document.getElementById('todate').value;
	var hidStatus = document.getElementById('hidStatus').value;
	if(frmdate!="")
	{
		if(todate=="")
		{
			alert("Please Select To Date");
			return false;
		}
	}
	
	window.location.href ="dashboard.php?action=bannerType_list&fstatus="+hidStatus+"&frmdate="+frmdate+"&todate="+todate;
	return true;
}

function FilterUser()
{
	var adstatus = document.getElementById('adstatus').value;
	var userRole = document.getElementById('userRole').value;
	var filter = document.getElementById('filter').value;
	
	
	window.location.href ="dashboard.php?action=advertiser_list&adstatus="+adstatus+"&userRole="+userRole+"&filter="+filter;
	return true;
}



function submit_login()
{	

 if(document.login.inputLogin.value=="")
 { 
   document.getElementById("error").style.display = "";
   document.getElementById("msg").style.display = "none";
   document.getElementById("error").innerHTML='Please Enter User Name';   
   return false;
 }  
 if(document.login.inputPassword.value=="")
 { 	
	document.getElementById("error").style.display = "";
	document.getElementById("error").innerHTML='Please Enter Password'; 
	return false;
 }	 
 
 //document.login.submit();
 
}

function emailManager()
{

	 if(document.emailManagerForm.subjects.value=="")
	 { 
	   document.getElementById("error").style.display = "";   
	   document.getElementById("error").innerHTML='Please Enter Subject';   
	   return false;
	 } 
	 if(document.emailManagerForm.code.value=="")
	 { 
	   document.getElementById("error").style.display = "";   
	   document.getElementById("error").innerHTML='Please Enter Code';   
	   return false;
	 } 

	
	document.emailManagerForm.action="scripts/insert_emailManager.php";
	//document.emailManagerForm.submit();

}


function Upload() {
    //Get reference of FileUpload.
    var fileUpload = document.getElementById("fileUpload");
 
    //Check whether the file is valid Image.
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height > 100 || width > 100) {
                        alert("Height and Width must not exceed 100px.");
                        return false;
                    }
                    alert("Uploaded image has valid Height and Width.");
                    return true;
                };
 
            }
        } else {
            alert("This browser does not support HTML5.");
            return false;
        }
    } else {
        alert("Please select a valid Image file.");
        return false;
    }
}





function getCheck(email)
{
	$.ajax({
			url: 'scripts/getCheck.php',
			type: 'POST',
			data: {           
				'email': email,
				'type': 'acheck'
			 },
			
			success:function(response){
			  // alert(response);
			   if(response=="duplicate")
				{
				document.getElementById("error").style.display = "";   
				document.getElementById("error").innerHTML='Email Id Already Registered!';   
				return false;
			   }else{
				document.getElementById("error").style.display = "none";   
				document.getElementById("error").innerHTML=""; 				
				
				return true;
			   }
		   }
	   });
	   //return true;
}


function edit_data(id,action)
{
	document.location.href="dashboard.php?action="+action+"&d="+id+"&mode=edit";
	
}
function BlockType(id,action,type)
{
	document.location.href="dashboard.php?action="+action+"&d="+id+"&mode="+type;
}


function delete_records(id,action)
{
	var i=window.confirm("Are You Sure About Deactive Of Data");
	if(i)
	{		
		document.location.href="scripts/insert_"+action+".php?d="+id+"&mode=delete";
	}
	
}

function Active_records(id,action)
{
	var i=window.confirm("Are You Sure to Active Of Data");
	if(i)
	{		
		document.location.href="scripts/insert_"+action+".php?d="+id+"&mode=active";
	}
	
}

function cancel(page)
{	
	window.location.href="dashboard.php?action="+page;
}

function validateUrl(Url) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(Url);
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function IsAlpha(s){

var k;
document.all ? k = s.keyCode : k = s.which;
return ((k > 64 && k < 91) || (k > 96 && k < 123) || k ==8 || k==9||
   k==13|| k==0|| k==46 || k==127 || k==39 || k==32);

// All characters are numbers.
// return true;
}


function isInteger(obj)
{
    var i;
	var s=obj.value;
	s = s.toString();
	var value_obj='';
      for (i = 0; i < s.length; i++)
      {
		   var c = s.charAt(i);


		   if(c!='.')
		   {
		    	if(c==' ')
		   		{
			   		obj.value=value_obj;
			   		return false;
		   		}
			   if (isNaN(c))
			   {
					obj.value=value_obj;
					return false;
			   }
		   }
		   value_obj=value_obj+c;
      }
      return true;
}

function CheckEmail(str) {
	
    if (str.length == 0) { 
		//validateEmail(str)
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				//alert(xmlhttp.responseText)
					//return xmlhttp.responseText;
				
				if(xmlhttp.responseText=='duplicate')
				{
					document.getElementById("error").style.display = ""; 
					document.getElementById("error").innerHTML = "Email Already Registered";
					return false;
				
				}
				if(xmlhttp.responseText=='')
				{
					
					return true;
				}
				
            }
        };
        xmlhttp.open("GET", "scripts/gethint.php?q=" + str, true);
        xmlhttp.send();
    }
}


function showHint(str) {
	
    if (str.length == 0) { 
		//validateEmail(str)
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				
				if(xmlhttp.responseText=='duplicate')
				{
				document.getElementById("error").style.display = ""; 
                document.getElementById("error").innerHTML = "Email Already Exist";
				return false;
				
				}else{
					document.getElementById("error").style.display = "none"; 
					document.getElementById("error").innerHTML = "";
				}
				
            }else{
				if(!validateEmail(str)) {
					document.getElementById("error").style.display = ""; 
					document.getElementById("error").innerHTML = "Please Enter Email ID";
					return false;
				}
			}
        };
        xmlhttp.open("GET", "scripts/getCheck.php?q=" + str, true);
        xmlhttp.send();
    }
}

function trim (str, charlist) 
{
	var whitespace, l = 0, i = 0;
    str += '';
    
    if (!charlist) {
        // default list  
		whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');    }
    
    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {            str = str.substring(i);
            break;
        }
    }
        l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;        }
    }
    
    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}


function decode_base64(s)
{
    var e = {}, i, k, v = [], r = '', w = String.fromCharCode;
    var n = [[65, 91], [97, 123], [48, 58], [43, 44], [47, 48]];

    for (z in n)
    {
        for (i = n[z][0]; i < n[z][1]; i++)
        {
            v.push(w(i));
        }
    }
    for (i = 0; i < 64; i++)
    {
        e[v[i]] = i;
    }

    for (i = 0; i < s.length; i+=72)
    {
        var b = 0, c, x, l = 0, o = s.substring(i, i+72);
        for (x = 0; x < o.length; x++)
        {
            c = e[o.charAt(x)];
            b = (b << 6) + c;
            l += 6;
            while (l >= 8)
            {
                r += w((b >>> (l -= 8)) % 256);
            }
         }
    }
    return r;
}

function checkemail()
    {
	
	   var email=document.getElementById("adv_email" ).value;
	
	   if(email)
	   {
	       $.ajax({
			   type: 'post',
			   url: 'scripts/getCheck.php',
			   data: {
			   user_email:email,
				type : 'acheck',
			   },
			   success: function (response) {
				   //alert(response)
			   
		       if(response=="1")	
               {
				   document.getElementById("error").style.display = ""; 
					document.getElementById("error").innerHTML = "Email Already Exist";
                  return false;	
               }
               else
               {
				  // document.getElementById("error").style.display = "none"; 
				//	document.getElementById("error").innerHTML = "";
                  return true;	
               }
             }
		   });


	    }
	    else
	    {
		  document.getElementById("error").innerHTML = "";
		   return false;
	    }
	
	}



function IsAlpha(s){

var k;
document.all ? k = s.keyCode : k = s.which;
return ((k > 64 && k < 91) || (k > 96 && k < 123) || k ==8 || k==9||
   k==13|| k==0|| k==46 || k==127 || k==39 || k==32);

// All characters are numbers.
// return true;
}

function isAlphaKey(e)
{
var t=e.which;return!((t<65||t>90)&&(t<97||t>123)&&32!=t&&t>31)
}

function isNumberKey(e)
{
var t=e.which;
return 118==t&&!0===e.ctrlKey||!(t>31&&(t<48||t>57))
}



function isInteger(obj)
{
    var i;
	var s=obj.value;
	s = s.toString();
	var value_obj='';
      for (i = 0; i < s.length; i++)
      {
		   var c = s.charAt(i);


		   if(c!='.')
		   {
		    	if(c==' ')
		   		{
			   		obj.value=value_obj;
			   		return false;
		   		}
			   if (isNaN(c))
			   {
					obj.value=value_obj;
					return false;
			   }
		   }
		   value_obj=value_obj+c;
      }
	 
	 if(s.length<10)
	 {
		return false;	 
	}
      return true;
}


// pass generat//
var Password = {
 
  _pattern : /[a-zA-Z0-9_\-\@#\+]/,
  
  
  _getRandomByte : function()
  {
    // http://caniuse.com/#feat=getrandomvalues
    if(window.crypto && window.crypto.getRandomValues) 
    {
      var result = new Uint8Array(1);
      window.crypto.getRandomValues(result);
      return result[0];
    }
    else if(window.msCrypto && window.msCrypto.getRandomValues) 
    {
      var result = new Uint8Array(1);
      window.msCrypto.getRandomValues(result);
      return result[0];
    }
    else
    {
      return Math.floor(Math.random() * 256);
    }
  },
  
  generate : function(length)
  {
    return Array.apply(null, {'length': length})
      .map(function()   
      {
        var result;
        while(true) 
        {
          result = String.fromCharCode(this._getRandomByte());
          if(this._pattern.test(result))
          {
            return result;
          }
        }        
      }, this)
      .join('');  
  }    
    
};