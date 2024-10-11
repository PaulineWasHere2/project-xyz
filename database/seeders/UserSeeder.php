<?php

namespace Database\Seeders;

use App\Models\Code;
use App\Models\User; // Importer le modèle User
use App\Services\CodeService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table.
     */
    public function run(): void
    {
        // Créer des utilisateurs en utilisant un tableau
        $users = User::factory()->count(10)->create();

        // Boucle pour créer chaque utilisateur
        foreach ($users as $user) {
            Code::factory()->count(5)->create([
                'host_id' => $user->id,
                'guest_id' => null,
                'code' => CodeService::generateCode(5),
            ]);
        }
    }
}
