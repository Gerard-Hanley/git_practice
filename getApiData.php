
<?php

$geonamesErrorCodes = {
     10:    "Authorization Exception"
    ,11:	"record does not exist"
    ,12:    "other error"
    ,13:	"database timeout"
    ,14:	"invalid parameter"
    ,15:	"no result found"
    ,16:	"duplicate exception"
    ,17:	"postal code not found"
    ,18:	"daily limit of credits exceeded"
    ,19:	"hourly limit of credits exceeded"
    ,20:	"invalid input"
    ,22:	"server overloaded exception"
    ,23:	"service not implemented"
    ,24:	"radius too large"
    ,27:	"maxRows too large"
};

$errorValue = 0;

try{
$executionStartTime = microtime(true) / 1000;

$url='http://api.geonames.org/'.$_REQUEST['api'].$_REQUEST['ident1'].$_REQUEST['val1'].$_REQUEST['ident2'].$_REQUEST['val2'].'&username=gh2021';
$select = $_REQUEST['select'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);

$result=curl_exec($ch);

curl_close($ch);

$decode = json_decode($result,true);	

//throw new GeoApiException($geonamesErrorCodes[$decode['status']['value'])

$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "mission saved";
$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
$output['status']['message'] = $decode[$status];

}catch(Exception $e){

    document.getElementById("showError").innerHTML = $geonamesErrorCodes[$decode['status']['value']];
    $output['status']['code'] = "$decode['status']['value']";
    $output['status']['name'] = "error";
    $output['status']['description'] = "mission failed";
    $output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
    $output['status']['message'] = $geonamesErrorCodes[$decode['status']['value'];
}





if($select == 'none'){
    $output['data'] = $decode;
}else{
    $output['data'] = $decode[$select];
}

header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output); 

?>
