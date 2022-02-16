<script>
var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix,nOS;

// In Opera, the true version is after "Opera" or after "Version"
if ((verOffset=nAgt.indexOf("OPR"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}

//LBBrowser
else if ((verOffset=nAgt.indexOf("LBBROWSER"))!=-1) {
 browserName = "LBBROWSER";
 fullVersion = nAgt.substring(verOffset+8);
}
//UCBrowser
else if ((verOffset=nAgt.indexOf("UCBrowser"))!=-1) {
 browserName = "UCBrowser";
 fullVersion = nAgt.substring(verOffset+8);
}

//Miui Browser
else if ((verOffset=nAgt.indexOf("MiuiBrowser"))!=-1) {
 browserName = "MiuiBrowser";
 fullVersion = nAgt.substring(verOffset+8);
}

//UBrowser
else if ((verOffset=nAgt.indexOf("UBrowser"))!=-1) {
 browserName = "UBrowser";
 fullVersion = nAgt.substring(verOffset+8);
}

// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("NET"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
//Edge
else if ((verOffset=nAgt.indexOf("Edge"))!=-1) {
 browserName = "Edge";
 fullVersion = nAgt.substring(verOffset+7);
}

// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}

// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
          (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}else{
 browserName = "Unable to detect";
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1)
   fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1)
   fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  ='0'// 'not available'+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}

if ((verOffset=nAgt.indexOf("Windows"))!=-1) {
 nOS = nAgt.substr(verOffset,15);
}
else if ((verOffset=nAgt.indexOf("Mac OS"))!=-1) {
 nOS="Macintosh\t"+nAgt.substr(verOffset,17);
 }

else if ((verOffset=nAgt.indexOf("Android"))!=-1) {
 nOS =nAgt.substr(verOffset,14);
}

else if ((verOffset=nAgt.indexOf("IOS"))!=-1) {
 nOS =nAgt.substr(verOffset,10);
}
else if ((verOffset=nAgt.indexOf("iPhone OS"))!=-1) {
 nOS =nAgt.substr(verOffset,17);
}
else{
 nOS ="Unable to detect"
}


document.write(''
 +'Browser = '+browserName  +'\t  '+fullVersion+'<br>'
 +'OS  = '+nOS+'<br>'
 + '['+navigator.userAgent+']'+'<br>'

 
)
</script>
