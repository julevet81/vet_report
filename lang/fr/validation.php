<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'email' => 'Le champ :attribute doit etre une adresse e-mail valide.',
    'unique' => 'La valeur du champ :attribute est deja utilisee.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caracteres.',
    ],
    'attributes' => [
        'name' => 'nom complet',
        'email' => 'e-mail',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'veterinary_authority_number' => 'numero d autorite veterinaire',
        'branch_id' => 'branche',
        'role' => 'role',
        'preferred_locale' => 'langue',
    ],
];