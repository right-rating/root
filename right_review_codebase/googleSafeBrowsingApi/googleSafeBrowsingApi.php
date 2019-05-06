<?php
// Set the API key for my test account
$apiKey = "AIzaSyBmq9mnZCsSskO5w6vcC860tRYoT4OUoWU";

//request body
// {
//     "client": {
//       "clientId":      "yourcompanyname",
//       "clientVersion": "1.5.2"
//     },
//     "threatInfo": {
//       "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
//       "platformTypes":    ["WINDOWS"],
//       "threatEntryTypes": ["URL"],
//       "threatEntries": [
//         {"url": "http://www.urltocheck1.org/"},
//         {"url": "http://www.urltocheck2.org/"},
//         {"url": "http://www.urltocheck3.com/"}
//       ]
//     }
//   }
$data = array("client"=>array("clientId"=>"myCompany", "clientVersion"=>"1.5.2"),
                "threatInfo"=>array("threatTypes"=> array("MALWARE", "SOCIAL_ENGINEERING"),
                                    "platformTypes"=>array("WINDOWS"),
                                    "threatEntryTypes"=>array("URL"),
                                    "threatEntries"=>array(
                                                            array("url"=>$_GET['item_url'])
                                                            )
                                    )
            );
$data_string = json_encode($data, JSON_UNESCAPED_SLASHES);

//step1
// $cSession = curl_init("https://safebrowsing.googleapis.com/v4/threatMatches:find?key=".$apiKey);
$cSession = curl_init();

//step2
curl_setopt($cSession,CURLOPT_URL,"https://safebrowsing.googleapis.com/v4/threatMatches:find?key=".$apiKey);
curl_setopt($cSession, CURLOPT_CUSTOMREQUEST, "POST"); 
curl_setopt($cSession, CURLOPT_POST, true);
curl_setopt($cSession, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($cSession,CURLOPT_RETURNTRANSFER, true);

//Not necessary
// curl_setopt($cSession,CURLOPT_HEADER, true);

// Add headers to the HTTP command
curl_setopt($cSession,CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    'Content-Length: ' . strlen($data_string)
));


//step3
$results = curl_exec($cSession);

//check for error
$err = curl_error($cSession);


//step4
curl_close($cSession);

// Convert the results to an associative array
$resultData = json_decode($results);

// Let's just get one of the items and echo the JSON for that only.
echo json_encode($resultData);

?>