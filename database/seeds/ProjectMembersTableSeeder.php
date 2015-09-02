<?php

use CodeProject\Entities\ProjectMembers;
use Illuminate\Database\Seeder;

class ProjectMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectMembers::truncate();
        factory(ProjectMembers::class,50)->create();
    }
}
