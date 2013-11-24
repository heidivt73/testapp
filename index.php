<?php
$resp = 'not set';

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
    </script>

    <script type="text/javascript">
      function logResponse(response) {
        if (console && console.log) {
          console.log('The response was', response);
        }
      }

      $(function(){
        // Set up so we handle click on the buttons
        $('#postToWall').click(function() {
          FB.ui(
            {
              method : 'feed',
              link   : $(this).attr('data-url')
            },
            function (response) {
              // If response is null the user canceled the dialog
              if (response != null) {
                logResponse(response);
              }
            }
          );
        });

        $('#sendToFriends').click(function() {
          FB.ui(
            {
              method : 'send',
              link   : $(this).attr('data-url')
            },
            function (response) {
              // If response is null the user canceled the dialog
              if (response != null) {
                logResponse(response);
              }
            }
          );
        });

        $('#sendRequest').click(function() {
          FB.ui(
            {
              method  : 'apprequests',
              message : $(this).attr('data-message')
            },
            function (response) {
              // If response is null the user canceled the dialog
              if (response != null) {
                logResponse(response);
              }
            }
          );
        });
      });
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
        <input type="button" value="Create Preview" onClick="<?php createPreview(); ?>;setResponseLabel(<?php echo $resp ?>);"/>
        <input type="text" id="responseLabel"><?php echo $resp ?></input>
        
    </form>
    <iframe id="previewPlaceholder">
    </iframe> 
  </body>
</html>
