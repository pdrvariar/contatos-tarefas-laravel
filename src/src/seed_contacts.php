<?php

use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Str;

$user = User::first();

if (!$user) {
    echo "Nenhum usuário encontrado.\n";
    exit;
}

echo "Inserindo 20 contatos para o usuário: " . $user->email . "\n";

for ($i = 1; $i <= 20; $i++) {
    Contact::create([
        'name' => "Contato Teste " . Str::random(5),
        'email' => "teste" . Str::random(5) . "@exemplo.com",
        'phone' => "(" . rand(11, 99) . ") 9" . rand(1000, 9999) . "-" . rand(1000, 9999),
        'user_id' => $user->id
    ]);
}

echo "20 contatos inseridos com sucesso.\n";
