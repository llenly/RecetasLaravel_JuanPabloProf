<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // aqui llamas a los seeder que quieres correr
        $this->call(CategoriasSeeder::class);
        $this->call(UsuarioSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
