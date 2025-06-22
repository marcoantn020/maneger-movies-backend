<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, post, postJson, putJson};

 // [] Criar usuário (POST /api/users)
 // [] Validação de criação
 // [] Atualizar usuário (PUT /api/users/{id})
 // [] Validação de atualização

uses(RefreshDatabase::class);

/*
 * Test 01
 */
dataset('userAttributes', [
    [
        [
            'first_name'            => 'Neo',
            'last_name'             => 'Anderson',
            'email'                 => 'neo@matrix.io',
            'password'              => 'StrongP@ss123',
            'password_confirmation' => 'StrongP@ss123',
            'phone'                 => '91234‑5678',
            'photo'                 => null,
        ]
    ],
]);


test('pode criar um usuário', function (array $attributes) {
    post('/api/signup', $attributes)
        ->assertCreated()
        ->assertJsonFragment([
            'email'      => $attributes['email'],
            'phone' => $attributes['phone'],
        ]);

    expect(User::query()->count())->toBe(1);
})->with('userAttributes');

/*
 * Test 02
 */
test('pode atualizar um usuário', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    $update = [
        'first_name' => 'Updated',
        'phone'      => '91234‑0000',
    ];

    post("/api/update-me", $update)
        ->assertAccepted();

    expect($user->refresh()->first_name)->toBe('Updated');
});

