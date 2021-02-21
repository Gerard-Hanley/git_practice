
<?php

$executionStartTime = microtime(true) / 1000;
       
  

//check submit button has been pressed.

if(isset($_POST['#Submit1']|$_POST['#Submit2']|$_POST['#Submit3']){

        //submit1,2,3 has sucsessfully clicked...



        if(empty($_REQUEST['api']||$_REQUEST['ident1']||$_REQUEST['val1']||$_REQUEST['ident2']||$_REQUEST['val2']))

            // a variable was submitted that was empty
            header("Location: ..index.php?signup=empty");
            exit();
        }else{
            // all variable have been submitted.

            if(!filter_var($_REQUEST['val1'] < -90 | $_REQUEST['val1'] > 90)){
                //error latitude outside of range.  

                exit();
            }else{
                // variable 1 is in the specified range.    

                if(!filter_var($_REQUEST['val2'] < -90 | $_REQUEST['val2'] > 90)){
                //error longditude outside of range.
            
                exit();
                }else{
                   // variable 2 is in the specified range.

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
                        $output['status']['message'] = $decode[$status]
            
                    if($select == 'none'){
                        $output['data'] = $decode;
                    }else{
                        $output['data'] = $decode[$select];
                    }
            
            
            
                    header('Content-Type: application/json; charset=UTF-8');
            
                    echo json_encode($output); 
            





                }
            }
        }

}else{
    //error submit button not clicked
    header("Location: ../index.php?=signup=error");
        
}



?>
