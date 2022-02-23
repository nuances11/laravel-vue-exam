<?php

use App\Album;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Album::truncate();
        $albums = Http::get('https://jsonplaceholder.typicode.com/albums');
        $data = [];

        foreach ($albums->json() as $key => $album) {
            $data[] = [
                'user_id' => $album['userId'],
                'title' => $album['title'],
                'created_at' => Carbon::now()
            ];
        }

        Album::insert($data);
    }
}
