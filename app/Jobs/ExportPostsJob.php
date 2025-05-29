<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExportPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $filename;

    public function __construct(string $filename = null)
    {
        $this->filename = $filename ?? 'posts_' . now()->format('Ymd_His') . '.csv';
    }

    public function handle(): void
    {
        $path = storage_path('app/exports/' . $this->filename);
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $handle = fopen($path, 'w');

        // 欄位標題
        fputcsv($handle, ['ID', 'name', 'Content']);
        $count = 0;
        // 每 100 筆處理一次，避免爆 RAM
        Post::select('id', 'name', 'content')->lazy(100)->each(function ($post) use ($handle, &$count) {
            fputcsv($handle, [$post->id, $post->name, $post->content]);
            $count++;
        });
        Log::info("匯出完成，共寫入 {$count} 筆資料到 {$this->filename}");
        fclose($handle);
    }
}
