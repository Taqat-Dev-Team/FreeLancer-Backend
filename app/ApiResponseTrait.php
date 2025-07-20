<?php
namespace App;

trait ApiResponseTrait{



    public function apiResponse($data=null,$message=null,$status=null,$code=null){


        $array=[
            'status'=>$status,
            'code'=>$code,
            'message'=>$message,
            'data'=>$data,

        ];

        return response()->json($array, $code);
    }


    public function ApiResponsePaginationTrait($paginator=null, $message=null, $status=null, $code=null)
    {
        $response = [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => formatPagination($paginator)
        ];

        return response()->json($response, $code);
    }

}


