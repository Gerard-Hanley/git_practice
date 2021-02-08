
<?php

$executionStartTime = microtime(true) / 1000;



$url='http://api.geonames.org/'.$_REQUEST['api'].$_REQUEST['ident1'].$_REQUEST['val1'].$_REQUEST['ident2'].$_REQUEST['val2'].'&username=gh2021';

    //'http://api.geonames.org/addressJSON?lat=52.358&lng=4.881&username=gh2021';
    
    // find nearby postcodes 'http://api.geonames.org/findNearbyPostalCodesJSON?formatted=true&postalcode=8775&country=CH&radius=10&username=gh2021';
 
    // country info eg do not use"http://api.geonames.org/countryInfoJSON?formatted=true&lang=it&country=DE&username=gh2021";

    
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);

$result=curl_exec($ch);

curl_close($ch);

$decode = json_decode($result,true);	

$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "mission saved";
$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
$output['data'] = $decode;

if(empty ( mixed $output['data'] ) : bool){
    $decode['address'];
}

//$decode['streetSegment'];

// ** do not use ** $decode['geonames'];


header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output); 

?>
