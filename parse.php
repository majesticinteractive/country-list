<?php
//set required format here i.e. XML / JSON
$output_format = "json";

//set URL here
$url = "http://toolkit.majesticinteractive.co.za/public/" . $output_format . "/countries.php";

//CURL
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute
    $result = curl_exec($ch);
    if (!$result) {
        echo "CURL submission error";
               //CURL submission error - add custom error logging here
            exit();
    }
    //close connection
    curl_close($ch);
} catch (Exception $e) {
    echo "CURL error";
        //CURL error - add custom error logging here
        exit();
}

switch ($output_format) {
    case "json":
        $json = json_decode($result);
        if ($json->HTTP_STATUS_CODE == "200") {
            //POST successful
            //loop through returned data
            foreach ($json->data as $obj) {
                echo $obj->id . "," . $obj->country . "<br>";
            }
        } else {
            echo "Error";
                //Error - add custom error logging here
                exit();
        }
        break;
    case "xml":
        $xml = new SimpleXMLElement($result);
        if ($xml->HTTP_STATUS_CODE == "200") {
            //POST successful
            //loop through returned data
            foreach ($xml->data->element as $obj) {
                echo $obj->id . "," . $obj->country . "<br>";
            }
        } else {
            echo "Error";
                //Error - add custom error logging here
                exit();
        }
        break;
}?>