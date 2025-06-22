<?php

namespace App\Http\Controllers\Authenticator\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthRepository
{
    public function __construct(
        protected User $userModel
    ){}

    public function createNew($data): User
    {
        try {
            return DB::transaction(fn () => $this->userModel->create($data));
        } catch (\Throwable $e) {
            Log::error('Erro ao criar usuario', ['data' => $data, 'exception' => $e]);
            throw new \RuntimeException('Internal server error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function update($user, array $data)
    {
        $values = $this->removeNullItems($data);
        if (empty($values)) return false;

        try {
            return DB::transaction(fn () => $user->update($values));
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar usuario logado', ['data' => $data, 'exception' => $e]);
            throw new \RuntimeException('Internal server error: ' . $e->getMessage(), 500, $e);
        }
    }

    protected function removeNullItems(array $dados)
    {
        return array_filter($dados, fn ($value) => !empty($value));
    }
}
