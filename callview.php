<?php

function createPreview($fileURL) {
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	$data = array(url => $fileURL); //'https://cloud.box.com/shared/static/4qhegqxubg8ox0uj5ys8.pdf');
	$data_string = json_encode($data);
	
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://view-api.box.com/1/documents',
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

if (isset($_GET["fileURL"])) {
	$fileURL = $_GET["fileURL"];
	$view_session_id = createPreview($fileURL);
	echo $view_session_id;
}
