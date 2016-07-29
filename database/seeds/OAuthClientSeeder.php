<?php

use CodeProject\Entities\OauthClients;
use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OauthClients::class,10)->create();
    }
}
