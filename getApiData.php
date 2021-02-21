
<?php


$errorEmpty = false;
$executionStartTime = microtime(true) / 1000;

$geoBeginning = 'http://api.geonames.org/';
$api = $_REQUEST['api'];
$identifier1 = $_REQUEST['ident1']; 
$value1 = $_REQUEST['val1'];
$identifier2 = $_REQUEST['ident2']; 
$value2 = $_REQUEST['val2'];
$username = '&username=gh2021';

// check for empty fields in form that has been clicked.
if(empty($api) ||empty($identifier1)||empty($value1)||empty($identifier2)||empty($value2)){

    $output['status']['code'] = "400";
    $output['status']['name'] = "error";
    $output['status']['description'] = "mission failed";
    $output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
    $output['status']['message'] = 'Field not filled in!';
    $output['status']['error'] = true;
    
}else{
        $url=$geoBeginning.$api.$identifier1.$value1.$identifier2.$value2.$username;


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
        $output['status']['message'] = $decode;
        $output['status']['error'] = false;


}
    

    
    
    if($select == 'none'){
        $output['data'] = $decode;
    }else{
        $output['data'] = $decode[$select];
    }

    header('Content-Type: application/json; charset=UTF-8');

    echo json_encode($output); 

?>
