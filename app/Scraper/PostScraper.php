<?php

namespace App\Scraper;

use Goutte\Client;
use Str;

class PostScraper
{

    public function scrapePost($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $title = '';
        $title = $crawler
            ->filter("h1.dt-news__title")
            ->first()->text();

        $short_description = $crawler
            ->filter(".dt-news__sapo h2")
            ->first()->text();
        $content = $crawler
            ->filter(".dt-news__content")
            ->first()->html();
        $slug = Str::slug($title);

        $post = [
            'name' => $title,
            'slug' => $slug,
            'short_description' => $short_description,
            'content' => $content,
            'status' => 1,
            'avatar' => '',
            'created_by' => 1,
            'is_featured' => 1,
        ];

        return $post;
    }

}