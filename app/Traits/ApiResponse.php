<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * 成功的回應
     * 
     * @param mixed $data 回應資料
     * @param string|null $message 成功訊息
     * @param int $code 狀態碼
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * 創建資源的成功回應
     * 
     * @param mixed $data 回應資料
     * @param string $message 成功訊息
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createdResponse($data, $message = 'Resource created successfully')
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * 沒有內容的成功回應
     * 
     * @return \Illuminate\Http\Response
     */
    protected function noContentResponse()
    {
        return response()->noContent();  // 返回 204 狀態碼
    }

    /**
     * 錯誤回應
     * 
     * @param string $message 錯誤訊息
     * @param int $code 狀態碼
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    /**
     * 表單驗證錯誤回應
     * 
     * @param array $errors 錯誤訊息
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse($errors)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $errors
        ], 422);
    }
}