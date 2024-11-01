<?php
    include 'API.php';
    $auth = false;
    $status = get_option('xnbot_status'); 
    $access_api_key = get_option('xnbot_api_key_token');
    $plan = array();
    if(isset($access_api_key) && $access_api_key != "" )
    {   
        $API = new API();
        $response = $API->xnbotCheckAccessToken();
        if($response == true){
            if( !file_exists( dirname(__FILE__)."/../scripts/XnBot_Script.js" )){
                $API->xnbotDownloadScript($access_api_key);
            }
            $plan = $API->xnbotGetPlan($access_api_key);
            $interactions = $API->xnbotGetInteractions($access_api_key);
            $auth = true;
        }else{
            $auth = false;
        }
    }

    if(isset($_POST['download_script']) && $_POST['download_script'] ==  "1" ){
        if(isset($access_api_key) && $access_api_key != "" ){
            $ret = $API->xnbotDownloadScript($access_api_key);
        }
    }
    if(isset($_POST['xnbot_status']) && $_POST['xnbot_status'] ==  "1" ){
        $flag = update_option( 'xnbot_status', 1 );
        if( $flag == false ){
            add_option( 'xnbot_status', '255', '', 'yes' );
            update_option( 'xnbot_status', 1 );
        }
        $status = get_option('xnbot_status'); 
    }

    if(isset($_POST['xnbot_status']) && $_POST['xnbot_status'] ==  "0" ){
        $flag = update_option( 'xnbot_status', 0 );
        if( $flag == false ){
            add_option( 'xnbot_status', '255', '', 'yes' );
            update_option( 'xnbot_status', 0 );
        }
        $status = get_option('xnbot_status'); 
        
    }
    
    if(isset($_POST['xnbot_disconnect']) && $_POST['xnbot_disconnect'] ==  "Disconnect XnBot" ){
        update_option( 'xnbot_status', '' );
        update_option( 'xnbot_script_last_download', '' );
        update_option( 'xnbot_api_key_token', '' );
        unlink( dirname(__FILE__)."/../scripts/XnBot_Script.js" );

        $status = get_option('xnbot_status'); 
        $auth = false;
    }

   
    
?>