<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
//        $this->middleware('actionLog');
    }

    protected function jsonFromArray(array $result){
        $data = isset($result['data']) ? $result['data'] : new \stdClass();
        $msg = isset($result['msg']) ? $result['msg'] : 'success';
        $status = isset($result['status']) ? $result['status'] : 0;
        return \Response::json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ]);
    }

    protected function json($data = '', $msg = 'success', $status = 0){
        if(is_array($data)){
            return \Response::json([
                'status' => $status,
                'msg' => $msg,
                'data' => empty($data) ? [] : $data,
            ]);
        }

        return \Response::json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data == '' ? [] : $data,
        ]);
    }

//    public static function validate($request, array $rules, $messages = [], $attributes = []){
//        if(is_object($request)){
//            $arr = $request->all();
//        }else{
//            $arr = $request;
//        }
//        $validator = \Validator::make($arr, $rules, $messages, $attributes);
//        if($validator->fails()) {
//            throw new \App\Exceptions\InvalidRequestException($validator->getMessageBag()->toArray());
//        }
//    }
}
