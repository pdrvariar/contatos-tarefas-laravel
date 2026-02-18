<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedRandomContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-random-contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insere 20 contatos aleatórios para o primeiro usuário';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = \App\Models\User::first();

        if (!$user) {
            $this->error('Nenhum usuário encontrado no banco de dados.');
            return 1;
        }

        $this->info("Inserindo 20 contatos para: {$user->email}");

        for ($i = 1; $i <= 20; $i++) {
            $name = "Contato Teste " . \Illuminate\Support\Str::random(5);
            \App\Models\Contact::create([
                'name' => $name,
                'email' => strtolower(\Illuminate\Support\Str::random(8)) . "@exemplo.com",
                'phone' => "(" . rand(11, 99) . ") 9" . rand(1000, 9999) . "-" . rand(1000, 9999),
                'user_id' => $user->id
            ]);
        }

        $this->info('20 contatos inseridos com sucesso!');
        return 0;
    }
}
