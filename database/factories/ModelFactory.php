<?php

use CodeProject\Entities\Client;
use CodeProject\Entities\OauthClients;
use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectMembers;
use CodeProject\Entities\ProjectNote;
use CodeProject\Entities\ProjectTask;
use CodeProject\Entities\User;
use Faker\Generator;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(Client::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(Project::class, function (Generator $faker) {
    $owner = User::all()->lists('id');
    foreach ($owner as $value) {
        $o[] = $value;
    }
    $client = Client::all()->lists('id');
    foreach ($client as $value) {
        $c[] = $value;
    }
    return [
        'owner_id' => $faker->randomElement($o),
        'client_id' => $faker->randomElement($c),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'progress' => rand(1,100),
        'status' => rand(1,3),
        'due_date' => $faker->dateTime('now'),
    ];
});

$factory->define(ProjectNote::class, function (Generator $faker) {
    $project = Project::all()->lists('id');
    foreach ($project as $value) {
        $p[] = $value;
    }    
    return [
        'project_id' => $faker->randomElement($p),
        'title' => $faker->title,
        'note' => $faker->paragraph,        
    ];
});

$factory->define(ProjectTask::class, function (Generator $faker) {
    $project = Project::all()->lists('id');
    foreach ($project as $value) {
        $p[] = $value;
    }    
    return [
        'project_id' => $faker->randomElement($p),
        'name' => $faker->word,
        'start_date' => $faker->dateTime('now'),
        'due_date' => $faker->dateTime('now'),
        'status' => rand(1,3),
    ];
});

$factory->define(ProjectMembers::class, function (Generator $faker) {
    $project = Project::all()->lists('id');
    foreach ($project as $value) {
        $p[] = $value;
    }  
    $user = User::all()->lists('id');
    foreach ($user as $value) {
        $u[] = $value;
    }
    return [
        'project_id' => $faker->randomElement($p),        
        'user_id' => $faker->randomElement($u),        
    ];
});

$factory->define(OauthClients::class, function (Generator $faker) {
    return [
        'id' => $faker->md5,
        'secret' => $faker->text(10),
        'name' => $faker->name
    ];
});