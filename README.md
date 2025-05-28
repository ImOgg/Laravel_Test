1. Laravel 12 api.php要自己產出來
    - 新增api路由
    ```bash
    php artisan install:api
    ```

2. 使用以下命令建立PostApiTest測試檔案
    ```bash
    php artisan make:test PostApiTest
    ```
# Laravel API 開發指南

## RESTful API 狀態碼與響應封裝

### 常用 HTTP 狀態碼

#### 成功狀態碼
- **200 OK**: 請求成功，用於 GET 請求和成功的 UPDATE 操作
- **201 Created**: 資源創建成功，用於 POST 請求
- **204 No Content**: 請求成功但不返回任何內容，常用於 DELETE 操作

#### 客戶端錯誤狀態碼
- **400 Bad Request**: 請求格式錯誤，參數不符合要求
- **401 Unauthorized**: 未提供授權資訊或授權失敗
- **403 Forbidden**: 拒絕訪問，通常是權限不足
- **404 Not Found**: 請求的資源不存在
- **422 Unprocessable Entity**: 請求格式正確，但由於語義錯誤而無法處理

#### 伺服器錯誤狀態碼
- **500 Internal Server Error**: 伺服器內部錯誤
- **503 Service Unavailable**: 服務暫時不可用

### 各操作對應的推薦狀態碼

| 操作 | 方法 | 成功狀態碼 | 回應內容 |
|------|------|------------|---------|
| 創建資源 | POST | 201 Created | 新創建的資源 |
| 獲取資源列表 | GET | 200 OK | 資源列表 |
| 獲取單一資源 | GET | 200 OK | 單一資源 |
| 更新資源 | PUT/PATCH | 200 OK | 更新後的資源 |
| 刪除資源 | DELETE | 204 No Content | 無內容 |

## API 回應封裝

### 在app/Traits 創建 ApiResponse Trait

為了標準化 API 響應，我們可以創建一個 Trait 來處理所有回應：

```php
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

在控制器中使用 Trait
在任何需要使用這些 API 回應方法的控制器中：

1. 引入 Trait： 在控制器頂部添加：
<?php
use App\Traits\ApiResponse;

2. 在類宣告中使用 Trait：
<?php
class PostController extends Controller
{
    use ApiResponse;
    
    // 控制器方法...
}
3. 在控制器方法中使用 Trait 方法：
<?php
public function show($id)
{
    $post = Post::findOrFail($id);
    return $this->successResponse($post);
}