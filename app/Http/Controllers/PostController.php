<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $posts = Post::all();
        // return response()->json($posts);
        return $this->successResponse($posts, '成功獲取所有文章');
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'name.required' => '標題是必填的',
            'name.string' => '標題必須是字符串',
            'name.max' => '標題不能超過255個字符',
            'author.required' => '作者是必填的',
            'author.string' => '作者必須是字符串',
            'author.max' => '作者不能超過255個字符',
            'content.required' => '內容是必填的',
            'content.string' => '內容必須是字符串',
            'content.max' => '內容不能超過5000個字符',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $post = Post::create($validator->validated());
        return $this->createdResponse($post);
    }


    public function update($id)
    {
        $post = Post::findOrFail($id);
        $validatedData = request()->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ], [
            'name.required' => '標題是必填的',
            'name.string' => '標題必須是字符串',
            'name.max' => '標題不能超過255個字符',
            'author.required' => '作者是必填的',
            'author.string' => '作者必須是字符串',
            'author.max' => '作者不能超過255個字符',
            'content.required' => '內容是必填的',
            'content.string' => '內容必須是字符串',
            'content.max' => '內容不能超過5000個字符',
        ]);

        $post->update($validatedData);

        return response()->json($post);
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
