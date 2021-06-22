<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\CRUDService;
use App\Models\User;
use App\Rules\AllowLowerEnglish;
use App\Traits\CommonLogging;
use Illuminate\Support\Facades\Hash, DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;
use Exception;
use Throwable;


class UserController extends Base
{
    use CommonLogging;

    private $service;
    private $result;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        
        $this->result = [
            'code' => 1000,
            'message' => 'success.'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $this->result['data'] = $this->service->getUserListAddLastOrder($request->all());
        } catch(Throwable $e) {
            $this->result['code'] = 2000;
            $this->result['message'] = 'fail to get users';
            
            $logMessage = sprintf('[%s][%s][%s:%d] message : %s', __CLASS__, __FUNCTION__, $e->getFile(), $e->getLine(), $e->getMessage());
            $this->errorLog($logMessage);
        }

        return response()->json($this->result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $userDatas = $request->all();
        // 유효성 검사
        $rules = [
            'name' => ['bail', 'required', 'min:1', 'max:20', 'alpha'],
            'nickname' => ['bail', 'required', 'min:1', 'max:30', new AllowLowerEnglish],
            'password' => ['bail', 'required', 'min:10', Password::min(10)->letters()->mixedCase()->numbers()->symbols()],
            'email' => ['bail', 'required', 'max:100', 'email'],
            'phone_num' => ['bail', 'required', 'digits_between:10,20']
        ];
        $validator = $this->validateParameters($userDatas, $rules);

        if($validator->fails()) {
            return response()->json([
                'code' => 2000,
                'message' => $validator->errors(),
            ]);
        }

        // 회원 가입
        $userDatas['password'] = Hash::make($request->password);
        try{
            $joinResult = DB::transaction(function () use($userDatas) {
                return $this->service->add($userDatas);
            });
        } catch(Throwable $e) {
            $this->result['code'] = 2000;
            $this->result['message'] = 'fail to join user.';
            
            $logMessage = sprintf('[%s][%s][%s:%d] message : %s', __CLASS__, __FUNCTION__, $e->getFile(), $e->getLine(), $e->getMessage());
            $this->errorLog($logMessage);
        }

        return response()->json($this->result);
    }

    /**
     * 회원 상세 조회
     *
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        try{
            $this->result['user'] = $this->service->getById($id);
        } catch(Throwable $e) {
            $this->result['code'] = 2000;
            $this->result['message'] = 'fail to get user detail.';
            
            $logMessage = sprintf('[%s][%s][%s:%d] message : %s', __CLASS__, __FUNCTION__, $e->getFile(), $e->getLine(), $e->getMessage());
            $this->errorLog($logMessage);
        }

        return response()->json($this->result);
    }

    /**
     * 단일 회원의 주문 목록 조회
     *
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOrdersOfUser(int $id) : JsonResponse
    {
        try{
            $this->result['orders'] = $this->service->getOrdersOfUser($id);
        } catch(Throwable $e) {
            $this->result['code'] = 2000;
            $this->result['message'] = 'fail to get orders of user.';
            
            $logMessage = sprintf('[%s][%s][%s:%d] message : %s', __CLASS__, __FUNCTION__, $e->getFile(), $e->getLine(), $e->getMessage());
            $this->errorLog($logMessage);
        }
        
        return response()->json($this->result);
    }
}
