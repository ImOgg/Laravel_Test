<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ExportPostsJob;

class ExportPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:export {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '將 posts 匯出成 CSV 並透過 Queue 背景執行';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename') ?? null;

        ExportPostsJob::dispatch($filename);

        $this->info("匯出任務已推送至佇列！");
    }
}
