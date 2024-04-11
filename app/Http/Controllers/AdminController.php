<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Allowed_cities;
use App\Models\Vehicle_types;
use App\Models\Vehicle_models;
use App\Models\Vehicle_names;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
		if (!Auth::check()) {			 				
			 return Redirect::to('/login');
		}
		$nav_bar = 'dashboard';       
        return view('home.index',compact('nav_bar'));
    }

	public function manage_users(Request $request)
    {
		 if (!Auth::check()) {			 				
			 return Redirect::to('/login');
		}
		$nav_bar = 'manage_users';
        if ($request->ajax()) {            
			$data =  User::latest()->whereNotIn('user_type', [1])->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('is_verify', function($row){       														
							$status = $row->is_verify == 1 ? 'checked' : '';
							$status_val = $row->is_verify == 1 ? 'Verified' : 'Not Verified';
							$btn = "<div class='form-check form-switch' style='text-align:center;'>
							  <input class='form-check-input toggle-class' type='checkbox' id='flexSwitchCheckChecked' data-onstyle='success' data-offstyle='danger' data-toggle='toggle' data-on='Active' data-off='InActive' data-id=".$row->id." $status>
							  <label class='form-check-label' for='flexSwitchCheckChecked'>$status_val</label>
							</div>";							
                            return $btn; 
                    })->addColumn('user_type', function($row){       
							$user_type ='';
							if($row->user_type == 2)
							{
								$user_type ='Agent';
							}else if($row->user_type == 2){
								$user_type ='Driver';
							}else if($row->user_type == 3){
								$user_type ='Individual';
							}
							
							$utype = "<span class='badge bg-primary'>$user_type</span>";							
                            return $utype; 
                    })->addColumn('created_at', function($row){   
                            return date("d/m/Y H:i A",strtotime($row->created_at));
                    })
                    ->rawColumns(['is_verify','created_at','user_type'])
                    ->make(true);
        }
          
        return view('home.manage_users',compact('nav_bar'));
    }


	public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->is_verify = $request->status;
        $user->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
	
	public function manage_cities(Request $request)
    {
		if (!Auth::check()) {			 				
			 return Redirect::to('/login');
		}
		$allowed_cities = Allowed_cities::latest()->get();
		$nav_bar = 'manage_cities';
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
     
		return view('home.manage_cities',compact('allowed_cities','nav_bar'));
    }
     
	public function manage_vehicle_types(Request $request)
    {   
		if (!Auth::check()) {			 				
			 return Redirect::to('/login');
		}
		$manage_vehicle_types = Vehicle_types::latest()->get();
		$nav_bar = 'manage_types';
        if ($request->ajax()) {
			
            return Datatables::of($manage_vehicle_types)
				->addIndexColumn()
				->addColumn('action', function($row){

					   $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

					   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

						return $btn;
				})
				->rawColumns(['action'])
				->make(true);
        }
      
		return view('home.manage_types',compact('manage_vehicle_types','nav_bar'));
    }
	
	public function manage_vehicle_models(Request $request)
    {   
		if (!Auth::check()) {			 				
			 return Redirect::to('/login');
		}
		$nav_bar = 'manage_models';
		$manage_models = Vehicle_models::latest()->get();
        if ($request->ajax()) {
			
            return Datatables::of($manage_models)
				->addIndexColumn()
				->addColumn('action', function($row){

					   $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

					   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

						return $btn;
				})
				->rawColumns(['action'])
				->make(true);
        }
      
		return view('home.manage_models',compact('manage_models','nav_bar'));
    }

    public function save_models(Request $request)
    {
        Vehicle_models::updateOrCreate([ 'id' => $request->id],[
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description
        ]);        
   
        return response()->json(['success'=>'Model saved successfully.']);
    }

	public function save_vehicle_types(Request $request)
    {
        Vehicle_types::updateOrCreate([ 'id' => $request->id],[
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description
        ]);        
   
        return response()->json(['success'=>'City saved successfully.']);
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

	
    public function edit_vehicle_types($id)
    {
        $Vehicle_data = Vehicle_types::find($id);
        return response()->json($Vehicle_data);
    }
  
    public function destroy_vehicle_types($id)
    {
        Vehicle_types::find($id)->delete();
     
        return response()->json(['success'=>'Vehicle type deleted successfully.']);
    }

	public function edit_models($id)
    {
        $model_data = Vehicle_models::find($id);
        return response()->json($model_data);
    }
  
    public function destroy_models($id)
    {
        Vehicle_models::find($id)->delete();
     
        return response()->json(['success'=>'Model deleted successfully.']);
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
		// print_r($user->user_type);die;
		if($user->user_type != 1):
            return redirect()->to('login')
                ->withErrors("Not a valid credentials. Something went wrong.");
        endif;
		
		if($user->is_verify != 1):
            return redirect()->to('login')
                ->withErrors("User not Verified please contact to admin.");
        endif;
		
		
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
	
	public function manage_vehicle_name(Request $request)
    {   
		if (!Auth::check()) {			 				
			 return Redirect::to('/login');
		}
		$nav_bar = 'manage_vname';
		
		$manage_vehicle_name = Vehicle_names::select(['vehicle_names.id as vid','vehicle_names.vname','vehicle_models.name as vtype','vehicle_types.name as vmodel','vehicle_names.description'])
			->join('vehicle_models', 'vehicle_models.id', '=', 'vehicle_names.vmodel')
			->join('vehicle_types', 'vehicle_types.id', '=', 'vehicle_names.vtype')
			->orderBy('vehicle_names.id', 'desc')
            ->get();
			
		
		$manage_vehicle_models = Vehicle_models::select(["id","name"])->get();
		$manage_vehicle_types = Vehicle_types::select(["id","name"])->get();
        if ($request->ajax()) {
			
            return Datatables::of($manage_vehicle_name)
				->addIndexColumn()
				->addColumn('action', function($row){

					   $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->vid.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

					   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->vid.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

						return $btn;
				})
				->rawColumns(['action'])
				->make(true);
        }
      
		return view('home.manage_vehicle_name',compact('manage_vehicle_name','nav_bar','manage_vehicle_models','manage_vehicle_types'));
    }
	
	public function save_vehicle_name(Request $request)
    {
        Vehicle_names::updateOrCreate([ 'id' => $request->id],[
                'id' => $request->id, 
                'vname' => $request->vehicle_name,
                'vtype' => $request->vehicle_type,
                'vmodel' => $request->vehicle_model,
                'description' => $request->description
        ]);          
        return response()->json(['success'=>'Vehicle name saved successfully.']);
    }
	
	public function edit_vehicle_name($id)
    {
        $vehicle_name_data = Vehicle_names::find($id);
        return response()->json($vehicle_name_data);
    }
  
    public function destroy_vehicle_name($id)
    {
        Vehicle_names::find($id)->delete();
        return response()->json(['success'=>'Vehicle name deleted successfully.']);
    }
	
}
