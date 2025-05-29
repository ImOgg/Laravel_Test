<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;

    // 提取共用的驗證規則
    private function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ];
    }

    // 提取共用的錯誤訊息
    private function getValidationMessages()
    {
        return [
            'name.required' => '標題是必填的',
            'name.string' => '標題必須是字符串',
            'name.max' => '標題不能超過255個字符',
            'author.required' => '作者是必填的',
            'author.string' => '作者必須是字符串',
            'author.max' => '作者不能超過255個字符',
            'content.required' => '內容是必填的',
            'content.string' => '內容必須是字符串',
            'content.max' => '內容不能超過5000個字符',
        ];
    }

    // 提取共用的驗證方法
    private function validatePost(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules(),
            $this->getValidationMessages()
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        return $validator->validated();
    }

    public function index()
    {
        $posts = Post::all();

        // return $this->successResponse($posts, '成功獲取所有文章');
        return view('posts', ['posts' => $posts]);
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return $this->successResponse($post);
    }

    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'author' => 'required|string|max:255',
        //     'content' => 'required|string',
        // ], [
        //     'name.required' => '標題是必填的',
        //     'name.string' => '標題必須是字符串',
        //     'name.max' => '標題不能超過255個字符',
        //     'author.required' => '作者是必填的',
        //     'author.string' => '作者必須是字符串',
        //     'author.max' => '作者不能超過255個字符',
        //     'content.required' => '內容是必填的',
        //     'content.string' => '內容必須是字符串',
        //     'content.max' => '內容不能超過5000個字符',
        // ]);

        // if ($validator->fails()) {
        //     return $this->validationErrorResponse($validator->errors());
        // }

        // $post = Post::create($validator->validated());
        // return $this->createdResponse($post);

        $validated = $this->validatePost($request);

        // 如果驗證失敗，validatePost 方法會直接返回錯誤響應
        if (!is_array($validated)) {
            return $validated;
        }

        $post = Post::create($validated);
        return $this->createdResponse($post);
    }


    public function update($id, Request $request)
    {
        // $post = Post::findOrFail($id);
        // $validatedData = request()->validate([
        //     'name' => 'required|string|max:255',
        //     'author' => 'required|string|max:255',
        //     'content' => 'required|string|max:5000',
        // ], [
        //     'name.required' => '標題是必填的',
        //     'name.string' => '標題必須是字符串',
        //     'name.max' => '標題不能超過255個字符',
        //     'author.required' => '作者是必填的',
        //     'author.string' => '作者必須是字符串',
        //     'author.max' => '作者不能超過255個字符',
        //     'content.required' => '內容是必填的',
        //     'content.string' => '內容必須是字符串',
        //     'content.max' => '內容不能超過5000個字符',
        // ]);

        // $post->update($validatedData);

        // return $this->successResponse($post);

        $post = Post::findOrFail($id);

        $validated = $this->validatePost($request);

        // 如果驗證失敗，validatePost 方法會直接返回錯誤響應
        if (!is_array($validated)) {
            return $validated;
        }

        // 使用 fill 和 isDirty 來檢測是否有變化
        $post->fill($validated);

        if ($post->isDirty()) {
            $post->save();
            return $this->successResponse($post, '文章更新成功');
        }

        return $this->successResponse($post, '文章沒有變化');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $this->noContentResponse();
    }
}
