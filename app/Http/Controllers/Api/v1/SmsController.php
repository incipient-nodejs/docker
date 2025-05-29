<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Util\Auditor;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

/**
 * @OA\PathItem(path="/api/v1/sms")
 *
 * @OA\Tag(name="Send OTP", description="Operations for send sms(OTP)")
 */
class SmsController extends Controller
{

    /**
     * @OA\Post(
     *     tags={"Send OTP"},
     *     path="/api/v1/sms-opt",
     *     summary="Get code otp for create account",
     *     description="Send code OTP in phone number",
     *     @OA\RequestBody(
     *      required=true,
     *      description="Send OTP for create accout",
     *      @OA\JsonContent(
     *         required={"phoneNumber"},
     *         @OA\Property(
     *             property="phoneNumber",
     *             type="string",
     *             description="Your phone number"
     *         )
     *     )
     * ),
     *     @OA\Response(response=200, description="Login successful")
     * )
     */
    function sendOTP(Request $request){
        $request->validate(['phoneNumber' => 'required']);
        return $this->generatorOTP($request, $request->phoneNumber, null, false);
    }

    /**
     * @OA\Post(
     *     tags={"Send OTP"},
     *     path="/api/v1/sms-opt-forget",
     *     summary="Get code otp for recoved password",
     *     description="Send code OTP in phone number",
     *     @OA\RequestBody(
     *      required=true,
     *      description="Send OTP for recoved password",
     *      @OA\JsonContent(
     *         required={"phoneNumber"},
     *         @OA\Property(
     *             property="phoneNumber",
     *             type="string",
     *             description="Your phone number"
     *         )
     *     )
     * ),
     *     @OA\Response(response=200, description="Login successful")
     * )
     */
    function sendOTPForgetPassword(Request $request){
        $request->validate(['phoneNumber' => 'required']);
        $phoneNumber = $request->phoneNumber;
        $user = User::where('phone', $phoneNumber)->where(Auditor::filter())->first();
        $exists = isset($user->id);
        if(!$exists) return response()->json([], 400);
        $otp =  $this->generatorOTP($request, $phoneNumber, $user->name, true);
        return (object)["otp" => $otp, "user" => $user];
    }

    private function generatorOTP($request, $phoneNumber, $userName, $isRecover){

        $otp = rand(100000, 999999);
        \Log::info('phone No', ['phone' => $phoneNumber]);
        \Log::info('Generated OTP', ['otp' => $otp]);


        if (filter_var($phoneNumber, FILTER_VALIDATE_EMAIL)) {

            $htmlBody = view('emails.otp', ['otp' => $otp])->render();

            $response = Http::withBasicAuth(
                env('MAILJET_API_KEY'),
                env('MAILJET_SECRET_KEY')
            )->post('https://api.mailjet.com/v3.1/send', [
                'Messages' => [[
                    'From' => [
                        'Email' => env('MAIL_FROM_ADDRESS'),
                        'Name' => env('MAIL_FROM_NAME', 'TudKabir'),
                    ],
                    'To' => [[
                        'Email' => $phoneNumber,
                    ]],
                    'Subject' => 'Seu código OTP',
                    'HTMLPart' => $htmlBody,
                ]]
            ]);

            Log::info('OTP Email sent via Mailjet', ['response' => $response->json()]);

        } else {
            // Inside request get phone number
            $api_token = env('TOKEN_OTP_KEY');
            $url = env('TOKEN_OTP_URL');
            $sender = "TudKabir";

            $response = Http::withHeaders([
                'Authorization' => "Token {$api_token}", 'Content-Type' => 'application/json'
            ])->post($url, [
                'message' => $message,
                'from' => $sender,
                'to' => $phoneNumber
            ]);
            \Log::info('OTP SMS sent', ['response' => $response->body()]);
        }


        return $otp;
    }
}
