<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\CRUDService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->service->getList($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateJoin($request->all());

        if($validator->fails()) {
            return response()->json([
                'msg' => 'fail to validate form data.'
                ,'validatorErrorMsg' => $validator->errors()
            ]);
        }

        $joinUserRequest = collect([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'password' => \Hash::make($request->password),
            'email' => $request->email,
            'phone_num' => $request->phone_num,
            'gender' => $request->gender
        ]);

        $joinResult = $this->service->add($joinUserRequest);
        if( ! $joinResult) {
            return response()->json(['msg' => 'fail to join this user.']);
        }

        return response()->json([
            'code' => 1000,
            'msg' => 'welcome to join!'
        ]);
    }

    private function validateJoin(array $joinData)
    {
        return \Validator::make($joinData, [
            'name' => ['bail', 'required', 'min:1', 'max:20', 'unique:users', 'string'],
            'nickname' => ['bail', 'required', 'min:1', 'max:30', 'string'],
            'password' => ['bail', 'required', 'min:10'],
            'email' => ['bail', 'required', 'max:100', 'email'],
            'phone_num' => ['bail', 'required', 'min:10', 'max:20']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = $this->service->getById($id);

        return response()->json([
            'msg' => 'show detail user. id : '. $id,
            'user' => $user->toArray()
        ]);
    }

    public function showOrders(int $id)
    {
        $orders = $this->service->getById($id)->orders;
        
        return response()->json([
            'msg' => 'show orders of user. id : '. $id,
            'orders' => $orders->toArray()
        ]);
    }
}
