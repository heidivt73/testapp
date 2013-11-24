<?php
$resp = "not set";

function getResponse() {
	echo $resp;
}

function createPreview() {
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://view-api.box.com/1/documents',
		CURLOPT_USERAGENT => 'Heidi Sample cURL Request',
		CURLOPT_HTTPHEADER => array(
			"Authorization: Token 0i5v1j4aeakehzf0kua7x31hm5rj78im", "Content-Type: application/json"),
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => array(
			url => 'https://cloud.box.com/shared/static/4qhegqxubg8ox0uj5ys8.pdf'
		)
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	
}
?>
<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />

    <title><?php echo "Heidi's Page"; ?></title>
    <link rel="stylesheet" href="stylesheets/screen.css" media="Screen" type="text/css" />
    <link rel="stylesheet" href="stylesheets/mobile.css" media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)" type="text/css" />


    <script type="text/javascript" src="/javascript/jquery-1.7.1.min.js"></script>
    
    <script type="text/javascript">
		function setResponseLabel(newValue)
		{
			 $('#responseLabel').text = newValue;
		}
		
		function testHTTPRequest()
		{
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "http://www.codecademy.com/", false);
			xhr.send();
	
			document.getElementById('httpstatus').innerHTML = xhr.status;
			document.getElementById('httpresponse').innerHTML = xhr.statusText;

//			console.log(xhr.status);
//			console.log(xhr.statusText);
		}
    </script>

    <!--[if IE]>
      <script type="text/javascript">
        var tags = ['header', 'section'];
        while(tags.length)
          document.createElement(tags.pop());
      </script>
    <![endif]-->
  </head>
  <body>
	<form>
        <input id="urlField" type="text"/>
        <input type="button" value="Create Preview" onClick="<?php createPreview(); ?>"/>
        <span id="responseLabel"><?php getResponse(); ?></span>
        
    </form>
    <form>
    	<input type="button" value="test http" onClick="testHTTPRequest()" />
       <span id="httpstatus">abc</span>
       <span id="httpresponse">def</span>       
    </form>
    <iframe id="previewPlaceholder">
    </iframe> 
  </body>
</html>
