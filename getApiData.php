
<?php

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


$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "mission saved";
$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

if($select == 'none'){
    $output['data'] = $decode;
}else{
    $output['data'] = $decode[$select];
}



header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output); 

?>
