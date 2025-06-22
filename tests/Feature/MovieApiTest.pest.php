<?php

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;


//  endpoints
// [x] Criar filme (POST /api/movies)
// [x] Listar filmes (GET /api/movies)
// [x] Exibir filme (GET /api/movies/{id})
// [x] Atualizar filme (PUT /api/movies/{id})
// [x] Excluir filme (DELETE /api/movies/{id})
// [x] Validação de dados obrigatórios

uses(RefreshDatabase::class);

/*
 * Teste 01
 */
dataset('movieAttributes', function () {
    return [
        [
            [
                'title'       => 'The Matrix',
                'year'        => 1999,
                'genre'       => 'Sci‑Fi',
                'synopsis'    => 'A computer hacker learns about the true nature of reality and his role in the war against its controllers.',
            ]
        ],
    ];
});

test('pode criar um filme', function (array $attributes) {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    postJson('/api/movies', $attributes)
        ->assertCreated()
        ->assertJsonFragment([
            'title' => $attributes['title'],
            'year'  => $attributes['year'],
        ]);

    expect(Movie::query()->count())->toBe(1);
})->with('movieAttributes');

/*
 * Teste 02
 */
dataset('validationData', function () {
    return [
        'sem título'       => [['title'      => null]],
        'ano não numérico' => [['year'       => 'dois mil']],
        'url inválida'     => [['poster_url' => 'not‑an‑url']],
    ];
});

test('retorna erro de validação para campos obrigatórios/formatos', function (array $override) {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    $payload = [
        'title'      => 'Movie',
        'year'       => 2000,
        'genre'      => 'Action',
        'synopsis'   => 'Some synopsis',
    ];

    postJson('/api/movies', array_merge($payload, $override))
        ->assertStatus(422)
        ->assertJsonValidationErrors(array_keys($override));
})->with('validationData');

/*
 * Teste 03
 */
test('pode listar filmes', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    $user->movies()->saveMany(Movie::factory()->count(3)->make());

    $res = getJson('/api/movies')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

/*
 * Teste 04
 */
test('pode exibir um filme específico', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    $movie = Movie::factory()->for($user)->create();

    getJson("/api/movies/{$movie->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $movie->id]);
});

/*
 * Teste 05
 */
test('pode atualizar um filme', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    $movie = Movie::factory()->for($user)->create();

    $payload = ['title' => 'Updated Title'];

    putJson("/api/movies/{$movie->id}", $payload)
        ->assertAccepted();

    expect($movie->refresh()->title)->toBe('Updated Title');
});

/*
 * Test 06
 */
test('pode excluir um filme', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user, 'api');

    $movie = Movie::factory()->for($user)->create();

    deleteJson("/api/movies/{$movie->id}")
        ->assertNoContent();

    expect(Movie::query()->find($movie->id))->toBeNull();
});
