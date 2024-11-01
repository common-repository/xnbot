<?php 



/**
 * API CLASS
 */
    class API  
    {
        /** 
         *  PUBLIC FUNCTIONS
         * 
        */

        public function xnbotCheckAccessToken(){
            $token= get_option('xnbot_api_key_token');
            $params = array( 'api_key' => $token );
            $response = self::xnbotCurlRequest('checkToken',$params);  
                   
            if(isset($response->success) && $response->success == true){
               return true;
            }else{
                return false;
            }
        }

        public function xnbotCheckScript(){
            $token = get_option('xnbot_api_key_token');
            $last_date = get_option('xnbot_script_last_download');

            $params = array( 'api_key' => $token );
            $response = self::xnbotCurlRequest('checkScript',$params);    
            if(isset($response->success) && $response->success == true){
                if(date('Y-m-d H:i:s', strtotime($last_date)) < date('Y-m-d H:i:s', strtotime($response->updated_at ))  ){
                    self::xnbotDownloadScript($token);
                }
                return true;
            }else{
                return false;
            }
        }

        public function xnbotGetPlan($token){
            $params = array( 'api_key' => $token );
            $response = self::xnbotCurlRequest('getPlan',$params);    
            if(isset($response->success) && $response->success == true){
                return $response->plan;
            }else{
                return false;
            }
        }

        public function xnbotGetInteractions($token){
            $params = array( 'api_key' => $token );
            $response = self::xnbotCurlRequest('getInteractions',$params);    
            if(isset($response->success) && $response->success == true){
                return $response->interactions;
            }else{
                return false;
            }
        }

        /** 
         *  PRIVATE FUNCTIONS
         * 
        */

        function xnbotDownloadScript($token){
            if(self::xnbotCheckAccessToken()){
                $params = array( 'api_key' => $token );
                $response = self::xnbotCurlRequest('getScript',$params);          
                if(isset($response->success) && $response->success == true){
                    // File Save 
                    if(isset($response->source) && $response->source != ""){
                        $scriptFile = fopen(dirname(__FILE__)."/../scripts/XnBot_Script.js", "w") or die("Unable to open file!");
                        $txt = $response->source;
                        fwrite($scriptFile, $txt);
                        fclose($scriptFile);

                        if( isset($response->last_download_date) ){  
                            $flag = update_option( 'xnbot_script_last_download', $response->last_download_date );
                            if( $flag == false ){
                                add_option( 'xnbot_script_last_download', '255', '', 'yes' );
                                update_option( 'xnbot_script_last_download', $response->last_download_date );
                            }
                        }
                        return true;
                    }
                    return -3;
                }else{
                    return -2;
                }
            }else{
                return -1;
            }

        }

        function xnbotCurlRequest($endpoint, $params){

            $path = "https://admin.xnbot.io/api/".$endpoint ;
            $curl = curl_init( $path );
            curl_setopt( $curl, CURLOPT_POST, true );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $params );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
            $response = curl_exec( $curl );
            curl_close( $curl );

            return json_decode($response);
            
        }
    


    }
    




?>