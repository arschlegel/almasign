<style>
    body {
            font-family: Verdana, sans-serif;
            font-size:24px;
            margin:50px;
            border: solid #641A2B;
            border-width: 12px;
            padding:20px;
            background-color:#FFF8EF;
    }
</style>
<div style="float:right;"><img src="https://d2jv02qf7xgjwx.cloudfront.net/customers/2097/images/Vassar_Badges_Circle_Burgundy-02.png" height="200px"></div>

<?php 

// from https://developers.exlibrisgroup.com/alma/apis/docs/users/UFVUIC9hbG1hd3MvdjEvdXNlcnMve3VzZXJfaWR9/
// The update is done in a 'Swap All' mode: existing fields' information will be replaced with the incoming information. Incoming lists will replace existing lists.

// grab the email address (from the URL) that was entered
// (this is looking to match in Contact Information/Email Address)
$eaddr = $_GET["email"] . '@vassar.edu';

// configure timestamp
$datestr = date('m/d/Y H:i:s', time()); 

// global variable for the user's primary ID
$primID = "";

// response page content
echo("<div style='font-size:48px;'>Thank you for agreeing to our loan terms! <br /><br /> Please check your email for a confirmation.<br /><br /><br /><br /></div>");

// Here is where we pull the user info, copy it, edit it, and then send it back in to Alma--
$ch = curl_init();
$queryStr = "&q=email~" . $eaddr;
$queryParams = '?' . urlencode('lang') . '=' . urlencode('en') . '&' . urlencode('apikey') . '=' . 'YOURAPIKEYHERE' . '&limit=100&expand=full' . $queryStr;
curl_setopt($ch, CURLOPT_URL, 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/users/' . $queryParams);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

//Pass results to the SimpleXMLElement function
$xml = new SimpleXMLElement($server_output);

// access the next level of elements
$xml2 = $xml->children();

echo "<br /><br /><br />";

// create an XML string from the result
$xmlstr = simplexml_load_string($server_output);

// set up a new node to push onto the XML structure
$newxml = new SimpleXMLElement($server_output);
$newnote = $newxml->user[0]->user_notes->addChild('user_note');
$newnote->addAttribute('segment_type','Internal');
$newnote->addChild('note_type','LIBRARY');
$newnote->addChild('note_text','User signed agreement on ' . $datestr);
$newnote->addChild('user_viewable','false');


// DO I NEED THIS? 
$xml = simplexml_load_string($server_output);

// pull out the first (should be only) Primary ID
foreach ($xml->children() as $trow) {  
    $primID = $trow->primary_id;
    echo "<i>Primary ID is: " . $primID . "</i>";
}

// set up the new query to PUT the newly updated User Record back into the system
$queryParams = '?' . urlencode('lang') . '=' . urlencode('en') . '&' . urlencode('apikey') . '=' . 'YOURAPIKEYHERE';
$url = 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/users/' . $primID . $queryParams;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','accept: application/xml'));     //,charset=utf-8”);
curl_setopt($ch, CURLOPT_POST, true);  // need this to do the PUT req
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$xmluser2);  // was $xmlString
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);  // UNCOMMENT THIS TO EXEC THE CURL!
curl_close($ch);

if (!$response) 
{
    return false;
}
curl_close($ch);

// The message
$message = "Thank you for signing our Reserves agreement. Please be sure to abide by all due dates for which you are responsible, so that other students may have access to these items.\r\n\r\nIf you received this message in error, please email circulation@vassar.edu to let us know.\r\n\r\nThank you,\r\nThe Vassar College Libraries";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Send
mail($eaddr, 'Vassar Libraries: Reserves Agreement signed', $message);


echo ("</body>");
?>
