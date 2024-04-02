<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Allowed_cities;
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


	public function manage_cities(Request $request)
    {
   
		$allowed_cities = Allowed_cities::latest()->get();
        if ($request->ajax()) {
			
            return Datatables::of($allowed_cities)
				->addIndexColumn()
				->addColumn('action', function($row){

					   $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

					   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

						return $btn;
				})
				->rawColumns(['action'])
				->make(true);
        }
      
		return view('home.manage_cities',compact('allowed_cities'));
    }
     
	 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_cities(Request $request)
    {
        Allowed_cities::updateOrCreate([ 'id' => $request->id],[
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description
        ]);        
   
        return response()->json(['success'=>'City saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product
     * @return \Illuminate\Http\Response
     */
    public function edit_cities($id)
    {
        $product = Allowed_cities::find($id);
        return response()->json($product);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product
     * @return \Illuminate\Http\Response
     */
    public function destroy_cities($id)
    {
        Allowed_cities::find($id)->delete();
     
        return response()->json(['success'=>'City deleted successfully.']);
    }
	
	
	 

	/**
     * Display Manage types
     * 
     * @return Renderable
     */
    public function manage_types(Request $request)
    {
		 if (!Auth::check()) {			 		
								
			 return Redirect::to('/login');
		}

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
          
        return view('home.manage_types');
    }

	/**
     * Display Manage models
     * 
     * @return Renderable
     */
    public function manage_models(Request $request)
    {
		 if (!Auth::check()) {			 		
								
			 return Redirect::to('/login');
		}

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
          
        return view('home.manage_models');
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
