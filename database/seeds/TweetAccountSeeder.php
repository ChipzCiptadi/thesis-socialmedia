<?php

use Illuminate\Database\Seeder;

class TweetAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            'screen_name' => 'kompascom',
            'name' => 'Kompas.com',
            'last_tweet_id' => null,
            'is_active' => 1
        ];
        DB::table("tweet_account")->insert($data);
    }
}
