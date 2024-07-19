<?php

use App\Models\Usuarios\Aluno;
use App\Models\Usuarios\Professor;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create()->each(function ($user) {
            $user->aluno()->save(factory(Aluno::class)->make());
            $user->assignRole('aluno');
        });

        factory(User::class, 5)->create()->each(function ($user) {
            $user->aluno()->save(factory(Professor::class)->make());
            $user->assignRole('professor');
        });

        factory(User::class, 1)->create()->each(function ($user) {
            $user->aluno()->save(factory(Professor::class)->make());
            $user->assignRole(['professor', 'administrador']);
        });
    }
}
