<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ShopManagement\Shop;
use Illuminate\Support\Facades\{ Auth, Validator};
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserManagement\{ Menu,MenuPrivilege, Module, Service};

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'mobile_email'  => 'required',
            'password'      => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fieldType  = filter_var($request->mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $credentials= array($fieldType => $request->mobile_email, 'password' => $request->password);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);

    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'mobile' => 'required|string',
            'role_id' => 'required|integer|exists:roles,id',
            'dob'  => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'success'       => true,
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 60,
            'user'          => auth()->user()
        ]);
    }

    /**
     * role wise shop
    */
    public function roleWiseShop (Request $request)
    {
        $query = Shop::query();

        if ($request->shop_id) {
            $query = $query->where('shop_id', $request->shop_id);
        }

        $records = $query->get();

        if ($records->count() > 0 ) {

            return response()->json([
                'success'   => true,
                'data'      => $records
            ]);
        }

        return response()->json([
            'success'   => false,
            'data'      => 'Data not found'
        ]);
    }

    /**
     * get sidebar menu
    */
    public function sidebarMenus ($user_type, $role_id)
    {
        $query = Menu::select('module_id','service_id','url','name');

        if ($user_type != 1) {
            $privilegedMenuIds = MenuPrivilege::select('menu_id')->where('role_id', $role_id)->get()->toArray();
            $query = $query->whereIn('id', $privilegedMenuIds);
        }

        $allMenus = $query->get();

        $moduleIds = [];
        $serviceIds = [];

        foreach ($allMenus as $menu) {
            $moduleIds[] = $menu->module_id;
            $serviceIds[] = $menu->service_id;
        }

        $modules = Module::select('id','name',)
                    ->whereIn('id', $moduleIds)
                    ->orderBy('sorting_order', 'asc')
                    ->get();

        $services = Service::whereIn('id', $serviceIds)
                        ->select('id', 'name', 'module_id')
                        ->orderBy('sorting_order', 'asc')
                        ->get();


        if ($allMenus->count() > 0 ) {

            return response()->json([
                'success'   => true,
                'data'      => [
                    'modules'   => $modules,
                    'services'  => $services,
                    'menus'     => $allMenus
                ]
            ]);
        }

        return response()->json([
            'success'   => false,
            'data'      => [],
            'data'      => 'Data not found!!'
        ]);
    }
}
