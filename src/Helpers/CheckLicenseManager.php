<?php

namespace Dibiy\MgInstallable\Helpers;


use Exception;
use GuzzleHttp\Client;


class CheckLicenseManager
{


    public function checkLicenseKey($inputs){
        try{
            $urlApi= config('Installable.checkLicense.check_license_installer_api');
            $client = new Client();
            $url = $urlApi."verify-license";
            $response=$client->post($url,[
                'json'=>[
                    'domainName'=>$inputs['app_domainName'],
                    'key'=>$inputs['app_key']
                ]
            ]);
            $body= $response->getBody();
            $body = json_decode($body, true);
            $body= (object) $body;
            if($response->getStatusCode() == 200){
                if($body && $body->data){
                    $data=(object) $body->data;
                    return [
                        'status' => 'info',
                        'data'=>$data
                    ];
                }
                return [
                    'status' => 'info',
                    'message'=>$body->message
                ];
            }
            return [
                'status' => 'info',
                'message'=>$body->message
            ];

        }catch(Exception $e){
            return $this->getMessageError($e);
        }
    }

    public function getMessageError($e){
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
    
            // Check if it's a 400 Bad Request response
            if ($statusCode === 400) {
                $errorData = json_decode($body, true);
                
                if (isset($errorData['message'])) {
                    $errorMessage = $errorData['message'];
                    // Handle the specific error message here
                    return "Error: $errorMessage";
                } else {
                    // Handle the error without a specific message
                    return "Error: Bad Request";
                }
            } else {
                // Handle other types of errors (e.g., 500 Internal Server Error)
                return "Error: An unexpected error occurred.";
            }
        } else {
            // Handle other request-related exceptions
            return "Error: Unable to communicate with the server.";
        }
    }
}