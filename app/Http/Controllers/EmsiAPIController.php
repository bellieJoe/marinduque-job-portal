<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmsiAPIController extends Controller
{
    /* API Crededntials */ /* just uncomment if you have to used, Warning, this crededntials are only limited to 50 request */
    // Email: jandusayjoe14@gmail.com
    // private static $CLIENT_ID = "tks2leakw6xsqeiu";
    // private static $CLIENT_SECRET = "pCkcLCbC";

    // Email: kmorechta.nay@refo.site
    private static $CLIENT_ID = "o3rgzlbe44hw6nr9";
    private static $CLIENT_SECRET = "5U7bBr71";


    public static $ACCESS_TOKEN = null;
    // public $sampleSkill = "Proficient in Web Design and  Development, Knowledgeable in Photoshop, Positive attitude. Being calm and cheerful when things go wrong, Bilingual, Can multi-task depende sa sweldo, Pleasing personality depende sa boss, Has good communication skills, ";

    public static function connect(){
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://auth.emsicloud.com/connect/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "client_id=".self::$CLIENT_ID."&client_secret=".self::$CLIENT_SECRET."&grant_type=client_credentials&scope=emsi_open",
            CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded"
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;

        } else {
            self::$ACCESS_TOKEN = json_decode($response)->access_token;
        }
        
    }

    public static function isHealthy(){
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://emsiservices.com/skills/status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer ".self::$ACCESS_TOKEN
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            // return json_decode($response)->data->healthy;
            return $response;
        }
    }

    public static function extractSkills($skills){
        self::connect();
        
        $curl = curl_init();
        
        $jsonText = json_encode((object)['text'=> $skills] );

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://emsiservices.com/skills/versions/latest/extract/trace",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $jsonText,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer ".self::$ACCESS_TOKEN,
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if ( isset(json_decode($response)->message) ){
                echo $response;
                return http_response_code(404);
            } else {
                $skills = [
                    'generated' => [],
                    'related' => []
                ];
                $ids = [];
                if($response){
                    foreach(json_decode($response)->data->skills as $res){
                        array_push($skills['generated'], ["id" => $res->skill->id, "name" => $res->skill->name]) ;
                        array_push($ids, $res->skill->id);
                    }
                }
                $skills['related'] = !empty($ids) ? self::extractRealatedSkills($ids) : [];
                return $skills;
            }
            
        }
    }

    private static function extractRealatedSkills($skillIDs){

        $IDs = [
            "ids" => [...$skillIDs]
        ];
        $jsonIDs = json_encode( (object)$IDs );

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://emsiservices.com/skills/versions/latest/related",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $jsonIDs,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer ".self::$ACCESS_TOKEN,
            "Content-Type: application/json"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            if(isset(json_decode($response)->message)){
                echo $response;
                return http_response_code(404);
            }

            $relatedSkills = [];

            foreach(json_decode($response)->data as $res){
                array_push($relatedSkills, ["id" => $res->id, "name" => $res->name]) ;
            }
            return $relatedSkills;
        }
    }





}
