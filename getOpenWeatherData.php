
<?php

$executionStartTime = microtime(true) / 1000;

//  api.openweathermap.org/data/2.5/find?lat={23.75975}&lon={-77.53466}&cnt={10}&appid={723b6273c96ebf97d7f57f33dab6f741}


$openWeatherBeginning = 'https://api.openweathermap.org/data/2.5/find?units=metric&lat=';
$lat = $_REQUEST['lat'];
$openWeatherMiddle = '&lon='; 
$lon = $_REQUEST['lon'];
$openWeatherMiddle2 = '&cnt=10&appid='; 
$apiKey = '723b6273c96ebf97d7f57f33dab6f741';



   try{
        // check for empty fields since this is not directly entered something has gone wrong.
        if(empty($lat) || empty($lon)){

                throw new Exception('Field not filled in for openweather data!');

            }else{

                $url=$openWeatherBeginning.$lat.$openWeatherMiddle.$lon.$openWeatherMiddle2.$apiKey;
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL,$url);

                $result=curl_exec($ch);

                curl_close($ch);

                $decode = json_decode($result,true);	

                $output['status']['code'] = $decode['cod'] ?: "200";
                $output['status']['name'] = "ok";
                $output['status']['description'] = $decode['cod'] ?: "mission saved";
                $output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
                $output['status']['message'] = $decode['message'];

                $output['data'] = $decode;
                
                    //check for no data
                if(empty($output['data'])){
                    $output['status']['code'] = "201";
                }
            }
        }   

    catch(Exception $e){

        $output = array( "error" => array("code" => $e->getCode(), "message" => $e->getMessage()));
        $output['status']['name'] = "";

    }

        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode($output); 



?>
