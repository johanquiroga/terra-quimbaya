<?php

use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\Root::all()->isEmpty()) {
            $root = factory(\App\Models\Root::class)->create();
            \App\Models\Usuario::create([
                'idCC' => $root->id,
                'email' => $root->correoElectronico,
                'password' => $root->contraseña,
                'tipoUsuario' => 'root'
            ]);
        }
        //if (\App\Models\Administrador::all()->isEmpty()) {
        //    factory(\App\Models\Administrador::class, 100)->create()->each(function(\App\Models\Administrador $admin) {
        //        \App\Models\Usuario::create([
        //            'idCC'        => $admin->id,
        //            'email'       => $admin->correoElectronico,
        //            'password'    => $admin->contraseña,
        //            'tipoUsuario' => 'admin'
        //        ]);
        //    });
        //}
    }
}
