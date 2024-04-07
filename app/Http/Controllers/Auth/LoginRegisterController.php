<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Allowed_cities;
use App\Models\Vehicle_types;
use App\Models\Vehicle_models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Validator;

class LoginRegisterController extends Controller
{
     /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:250',            
			'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
			'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string|min:8|confirmed'
        ]);
			
        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'user_type' => $request->user_type,
            'is_verfiy' => 0,
            'password' => Hash::make($request->password)
        ]);

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => $data,
        ];

        return response()->json($response, 201);
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone_number' => 'required|string'         
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }

        $user = User::select(["id","name","email"])->where('phone_number', $request->phone_number)->first();		
        if(!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid phone number'
                ], 401);
        }

        $data['token'] = $user->createToken($request->phone_number)->plainTextToken;
        $data['otp'] = rand ( 10000 , 99999 );
        $data['user'] = $user;

        User::where('phone_number', $request->phone_number)->update(['otp' => $data['otp']]);
        
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];

        return response()->json($response, 200);
    } 

	/**
     * resend otp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend_otp(Request $request)
    {
		 $validate = Validator::make($request->all(), [
            'phone_number' => 'required|string'         
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }

		$otp = rand ( 10000 , 99999 );
		$user = User::where('phone_number', $request->phone_number)->first();
		if(!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid phone number'
                ], 401);
        }

        $data['token'] = $user->createToken($request->phone_number)->plainTextToken;
        $data['otp'] = $otp;

		$mail = new PHPMailer(true);
    
		User::where('phone_number', $request->phone_number)->update(['otp' => $otp]);
		
       /* try {    
          
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;         
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
    
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($request->email);
    
            $mail->isHTML(true);
    
            // $mail->Subject = $request->subject;
            $mail->Subject = "Otp";
            // $mail->Body    = $request->body;
            $mail->Body    = "Your otp = ".$otp;
			// print_r($mail);die;
			$mail->send();
            // if( !$mail->send() ) {
				 // $response = [
					// 'status' => 'failed',
					// 'message' => 'email not send successfully.',
					// 'data' => $data,
				// ];
            // }
                
            // else {				
				$response = [
					'status' => 'success',
					'message' => 'Email has been sent.',
					'data' => $data
				];
            // }
    
        } catch (Exception $e) {                
				 $response = [
					'status' => 'failed',
					'message' => 'Message could not be sent.',
					'data' => $data
				];
        }*/
		
       $response = [
			'status' => 'success',
			'message' => 'Email has been sent.',
			'data' => $data,
		];

        return response()->json($response, 201);
    }
	
	/**
     * Authenticate the user with otp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login_with_otp(Request $request)
    {
        $validate = Validator::make($request->all(), [            
            'phone_number' => 'required',
            'otp' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }

        // Check email exist
        $user = User::where('phone_number', $request->phone_number)->first();
		
		if(!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid phone number'
                ], 401);
        }


        if( $user->otp != $request->otp) {
            return response()->json([
                'status' => 'failed',
                'message' => 'wrong otp'
                ], 401);
        }

        $data['token'] = $user->createToken($request->phone_number)->plainTextToken;        
        $data['user'] = $user;
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];
		User::where('phone_number', $request->phone_number)->update(['otp' => '','remember_token' => $data['token']]);
        return response()->json($response, 200);
    } 

	
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
            ], 200);
    }    
	
	 public function allowed_cities(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone_number' => 'required|string'         
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }

        $allowed_cities = Allowed_cities::select(['id','name'])->get();		
        if(!$allowed_cities) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid phone number'
                ], 401);
        }

        $response = [
            'status' => 'success',
            'message' => 'Data fetch successfully.',
            'data' => $allowed_cities,
        ];

        return response()->json($response, 200);
    } 

	public function get_vehicle_type(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone_number' => 'required|string'         
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }

        $Vehicle_types = Vehicle_types::select(['id','name'])->get();		
        if(!$Vehicle_types) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid phone number'
                ], 401);
        }

        $response = [
            'status' => 'success',
            'message' => 'Data fetch successfully.',
            'data' => $Vehicle_types,
        ];

        return response()->json($response, 200);
    } 
	
	public function get_vehicle_model(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone_number' => 'required|string'         
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }

        $Vehicle_models = Vehicle_models::select(['id','name'])->get();		
       
		if (is_null($Vehicle_models->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid phone number'
            ], 200);
        }
		
        $response = [
            'status' => 'success',
            'message' => 'Data fetch successfully.',
            'data' => $Vehicle_models,
        ];

        return response()->json($response, 200);
    } 
	
	 public function check_token_exists(Request $request)
    {
        $validate = Validator::make($request->all(), [            
            'phone_number' => 'required',
            'token' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);  
        }
		$rtoken = $request->token;
        $user = User::select("id")->where('phone_number', $request->phone_number)->where('remember_token',$rtoken)->get();
		if (is_null($user->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Credentials',
            ], 200);
        }
		
        $response = [
            'status' => 'success',
            'message' => 'Token verified successfully',
        ];		
        return response()->json($response, 200);
    } 
}
