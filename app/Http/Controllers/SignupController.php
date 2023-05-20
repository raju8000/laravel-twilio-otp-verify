<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Twilio\Rest\Verify\V2\Service\VerificationInstance;

class SignupController extends Controller
{
    public function sendOtp(Request $request){
        
        try {
            $input = $request->all();
            $rules = array(
                'mobile_number' => "required",
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                $result = [
                    "status" => 0,
                    "message" => $validator->errors()->first(),
                     ];
                } else {
                    $sid = getenv("TWILIO_ACCOUNT_SID");
                    $token = getenv("TWILIO_AUTH_TOKEN");
                    $twilio = new Client($sid, $token);
                    $verification = $twilio->verify->v2->services(getenv("TWILIO_VERIFICATION_SERVICE"))
                                   ->verifications
                                   ->create($input['mobile_number'], "sms");

                    $result = [
                            "status" => $verification->status,
                            "to" => $verification->to,
                            "cnannel" => $verification->channel,
                        ];

                }
            
        } catch (\Exception $e) {
            Log::error([
                'Action' => 'Add',
                'message' => $e->getMessage()
            ]);

            $result = [
                "status" => 0,
                "message" => $e->getMessage()
            ];
        }
        return response($result);
    }

    public function verifyOtp(Request $request){
        
        try {
            $input = $request->all();
            $rules = array(
                'mobile_number' => "required",
                'otp' => "required"
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                $result = [
                    "status" => 0,
                    "message" => $validator->errors()->first(),
                  ];
            }else{
                $sid = getenv("TWILIO_ACCOUNT_SID");
                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio = new Client($sid, $token);

                $verification = $twilio->verify->v2->services(getenv("TWILIO_VERIFICATION_SERVICE"))
                                         ->verificationChecks
                                         ->create([
                                                      "to" => $input['mobile_number'],
                                                      "code" => $input['otp']
                                                  ]
                                         );
                                        
                $result = [
                    "status" => $verification->status,
                    "to" => $verification->to,
                    "cnannel" => $verification->channel,
                ];

            }
        }catch (\Exception $e) {
            Log::error([
                'Action' => 'Add',
                'message' => $e->getMessage()
            ]);

            $result = [
                "status" => 0,
                "message" => $e->getMessage()
            ];
        }
        return response($result);
    }
}
