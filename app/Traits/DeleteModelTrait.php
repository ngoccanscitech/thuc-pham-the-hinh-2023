<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait DeleteModelTrait
{
    public function deleteModelTrait($model)
    {
        try {
            $model->delete();
            return response()->json([
                'code'=>200,
                'message'=>'Success'
            ]);
        }catch (\Exception $exception)
        {
            Log::error('Message: '.$exception->getMessage().'--Line: '.$exception->getLine());
            return response()->json([
                'code'=>500,
                'message'=>'Fail'
            ]);
        }
    }
}
