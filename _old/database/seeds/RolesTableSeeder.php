<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            foreach (Role::all() as $role) {
                $role->delete();
            }

            $roles = [
                'administrador',
                'diretor',
                'coordenador',
                'professor',
                'aluno',
                'responsavel-aluno',
            ];

            foreach ($roles as $role) {
                Role::create(['name' => $role]);
            }
        });
    }
}
