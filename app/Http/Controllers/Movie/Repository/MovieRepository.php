<?php

namespace App\Http\Controllers\Movie\Repository;

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class MovieRepository
{
    public function __construct(
        protected Movie $movieModel
    ) {}

    public function createNew(array $data): Movie
    {
        $user = Auth::guard('api')->user();

        try {
            return DB::transaction(fn () => $user->movies()->create($data));
        } catch (Throwable $e) {
            Log::error('Erro ao criar filme', ['data' => $data, 'exception' => $e]);
            throw new RuntimeException('Internal server error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function all(string $search)
    {
        return Auth::guard('api')
            ->user()
            ->movies()
            ->when(
                filled($search),
                fn ($q) => $q->where('title', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate(10);
    }

    public function update(string $id, array $data)
    {
        $values = $this->removeNullItems($data);
        if (empty($values)) return false;

        $movie = $this->ownedMovie($id);

        try {
            return DB::transaction(function () use ($movie, $values) {
                $movie->update($values);
                return $movie->refresh();
            });
        } catch (Throwable $e) {
            Log::error('Erro ao atualizar filme', ['data' => $data, 'exception' => $e]);
            throw new RuntimeException('Internal server error: ' . $e->getMessage(), 500, $e);
        }
    }

    public function delete(string $id): void
    {
        $movie = $this->ownedMovie($id);

        try {
            DB::transaction(fn () => $movie->delete());
        } catch (Throwable $e) {
            Log::error('Erro ao deletar filme', ['exception' => $e]);
            throw new RuntimeException('Internal server error: ' . $e->getMessage(), 500, $e);
        }
    }

    protected function ownedMovie(string $id): Movie
    {
        return Auth::guard('api')
            ->user()
            ->movies()
            ->findOrFail($id);
    }

    protected function removeNullItems(array $dados)
    {
        return array_filter($dados, fn ($value) => !empty($value));
    }
}
