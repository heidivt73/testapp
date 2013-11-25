<?php

function createPreview() {
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	$data = array(url => 'https://cloud.box.com/shared/static/4qhegqxubg8ox0uj5ys8.pdf');
	$data_string = json_encode($data);
	
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://view-api.box.com/1/documents',
//		CURLOPT_USERAGENT => 'Heidi Sample cURL Request',
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_HTTPHEADER => array(
			"Authorization: Token 0i5v1j4aeakehzf0kua7x31hm5rj78im", "Content-Type: application/json", "Content-Length: " . strlen($data_string)),
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $data_string
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	
	// Now that we have a document ID, create the session
	$resp_obj = json_decode($resp);
	$data = array(document_id => $resp_obj->{'id'}, duration => 60);
	$data_string = json_encode($data);
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://view-api.box.com/1/sessions',
		CURLOPT_USERAGENT => 'Heidi Sample cURL Request',
		CURLOPT_HTTPHEADER => array(
			"Authorization: Token 0i5v1j4aeakehzf0kua7x31hm5rj78im", "Content-Type: application/json", "Content-Length: " . strlen($data_string)),
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $data_string
	));
	
	$resp = curl_exec($curl);

	// Now store the session id we got back
	$resp_obj = json_decode($resp);
	$view_session_id = $resp_obj->{'id'};
	
	// Close request to clear up some resources
	curl_close($curl);
	
//	$view_url = "https://view-api.box.com/view/" . $view_session_id;
	return $view_session_id;
	
}

$view_session_id = createPreview();

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
			 document.getElementById('responseLabel').innerHTML = newValue;
		}
		
		function testHTTPRequest()
		{
			var xhr = new XMLHttpRequest();
//			xhr.open("GET", "http://www.codecademy.com/", false);
			xhr.open("POST", "https://view-api.box.com/1/documents", false);
			xhr.setRequestHeader("Authorization", "Token 0i5v1j4aeakehzf0kua7x31hm5rj78im");
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.send('{"url": "https://cloud.box.com/shared/static/4qhegqxubg8ox0uj5ys8.pdf"}');
	
			document.getElementById('httpstatus').innerHTML = xhr.status;
			document.getElementById('httpresponse').innerHTML = xhr.statusText;

//			console.log(xhr.status);
//			console.log(xhr.statusText);
		}
		function loadIFrame(viewSessionID)
		{
			var viewFrameURL = "https://view-api.box.com/view/" + viewSessionID;
//			document.getElementById('viewFrame').contentWindow.postMessage(viewFrameURL, 'http://peaceful-river-4267.herokuapp.com/');
			document.getElementById('responseLabel').innerHTML = viewFrameURL;
		}
    </script>
	<script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
    <script>
		function fileChosen(event)
		{
			alert(event.fpfile);
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
  <body onLoad="loadIFrame('<?php echo $view_session_id; ?>')">
  
<!--	<iframe id="viewFrame" src="iframe_placeholder.html" seamless style="border:none; width:750px; height:440px;" >
	</iframe> -->
	<form>
<!--        <input id="urlField" type="text"/>
        <input type="button" value="Create Preview" onClick="setResponseLabel('heidi')"/> -->
		<input type="filepicker" id="inkFilePicker" data-fp-apikey="ARdCI6vhZTriwXOwUTy9Kz" onChange="fileChosen(event, '<?php echo $view_session_id; ?>')"/>
        <a href="#" onClick="window.open(document.getElementById('responseLabel').innerHTML, '_self')">
        <span id="responseLabel">abc</span></a>
    </form>
<!--    <form>
    	<input type="button" value="test http" onClick="testHTTPRequest()" />
       <span id="httpstatus">abc</span>
       <span id="httpresponse">def</span>       
    </form> -->
  </body>
</html>
