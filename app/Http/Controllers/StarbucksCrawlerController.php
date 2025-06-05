<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

// 安裝：
// composer require guzzlehttp/guzzle
// composer require symfony/dom-crawler symfony/css-selector


class StarbucksCrawlerController extends Controller
{
     public function fetch()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://www.starbucks.com.tw/products/food/view.jspx?catId=77');
        $html = (string) $response->getBody();

        $crawler = new Crawler($html);

        $crawler->filter('.title_cn')->each(function ($node) {
            Log::info('中文品名：' . $node->text());
            Log::info('中文品名：' . $node->text());
        });

        return response()->json(['status' => 'ok']);
    }
}
