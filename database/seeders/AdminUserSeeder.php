<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder : Utilisateur administrateur par défaut
 *
 * Usage : php artisan db:seed --class=AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si l'admin existe déjà
        if (User::where('email', 'admin@portfolio.local')->exists()) {
            $this->command->info('❌ L\'utilisateur admin existe déjà.');
            return;
        }

        // Créer l'utilisateur admin
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@portfolio.local',
            'password' => Hash::make('password'), // À changer en production !
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Utilisateur admin créé avec succès !');
        $this->command->info('📧 Email: admin@portfolio.local');
        $this->command->info('🔑 Mot de passe: password');
        $this->command->warn('⚠️  Changez ce mot de passe en production !');
    }
}
