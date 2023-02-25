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
                    'name'=>$inputs['app_name'],
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
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}