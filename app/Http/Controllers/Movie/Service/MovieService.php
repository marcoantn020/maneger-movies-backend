<?php

namespace App\Http\Controllers\Movie\Service;

use App\Http\Controllers\Movie\MovieDTO;
use App\Http\Controllers\Movie\Repository\MovieRepository;

class MovieService
{
    public function __construct(
        protected MovieRepository $movieRepository
    )
    {
    }

    public function create(array $data)
    {
        return $this->movieRepository->createNew($data);
    }

    public function update(string $id, array $data)
    {
        return $this->movieRepository->update($id, $data);

    }

    public function delete(string $id)
    {
        $this->movieRepository->delete($id);
    }
}
