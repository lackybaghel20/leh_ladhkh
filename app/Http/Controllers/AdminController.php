<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use DataTables;

class AdminController extends Controller
{
     /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function index(Request $request)
    {
		 if (!Auth::check()) {			 		
								
			 return Redirect::to('/login');
		}

		// echo "<pre>";print_r($user);die;
		
        if ($request->ajax()) {
            $data = User::select('*');
			
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('is_verify', function($row){       							
							if($row->is_verify == 1){
								$btn = "<span class='edit btn btn-primary btn-sm'>Verify</span>";
							}else{
								$btn = "<span  class='edit btn btn-danger btn-sm'>Not Verify</span>";
								
							}
      
                            return $btn; 
                    })->addColumn('created_at', function($row){   
                            return date("d/m/Y H:i A",strtotime($row->created_at));
                    })
                    ->rawColumns(['is_verify','created_at'])
                    ->make(true);
        }
          
        return view('home.index');
    }

	/**
     * Display login page.
     * 
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
			
        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
		
        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user) 
    {
        return redirect()->intended();
    }
}
