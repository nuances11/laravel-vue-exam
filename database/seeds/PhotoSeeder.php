<?php

use App\Photo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Photo::truncate();
        $photos = Http::get('https://jsonplaceholder.typicode.com/photos');
        $data = [];

        foreach ($photos->json() as $key => $photo) {
            $data[] = [
                'album_id' => $photo['albumId'],
                'title' => $photo['title'],
                'url' => $photo['url'],
                'thumbnailUrl' => $photo['thumbnailUrl'],
                'created_at' => Carbon::now()
            ];
        }

        Photo::insert($data);
    }
}
