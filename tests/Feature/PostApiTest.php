<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_post_via_api()
    {
        $payload = [
            'name' => '測試文章',
            'author' => '小明',
            'content' => '這是一段測試內容',
        ];

        $response = $this->postJson('/api/posts', $payload);

        $response->assertStatus(201); // 根據你 controller 的回傳調整（201 Created）

        $this->assertDatabaseHas('posts', [
            'name' => '測試文章',
            'author' => '小明',
            'content' => '這是一段測試內容',
        ]);
    }

    public function test_read_post_list()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonCount(3); // 回傳三筆
    }

    public function test_show_single_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $post->name]);
    }


    public function test_update_post()
    {
        $post = Post::factory()->create();

        $updated = [
            'name' => '新標題',
            'author' => '小華',
            'content' => '這是更新後的內容',
        ];

        $response = $this->putJson("/api/posts/{$post->id}", $updated);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'name' => '新標題',
            'author' => '小華',
            'content' => '這是更新後的內容',
        ]);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();
    
        $response = $this->deleteJson("/api/posts/{$post->id}");
    
        $response->assertStatus(200); // 修改期望的狀態碼
        $response->assertJson(['message' => 'Post deleted successfully']); // 驗證返回的消息
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}


