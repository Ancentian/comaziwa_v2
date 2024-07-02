<?php

    namespace App\Models;
    
    
    class HubtelSMS
    {
        protected $client;
        protected $baseUrl = 'https://smsc.hubtel.com/v1/messages/send?';
        protected $config = [];
        
        public function __construct(array $config)
        {
            $this->config = $config;
        }
        
        public function sendSMS($to, $message)
        {
            
            $query = array(
              "clientid" => $this->config['client_id'],
              "clientsecret" => $this->config['client_secret'],
              "from" => $this->config['sender_id'],
              "to" => $to,
              "content" => $message
            );
            
            logger(json_encode($query));
            
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
              CURLOPT_URL => $this->baseUrl . http_build_query($query),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => "GET",
            ]);
            
            $response = curl_exec($curl);
            $error = curl_error($curl);
            
            curl_close($curl);
            
            if ($error) {
              
              logger($error);
            } else {
              logger($response);
            }
        }
    }
