<?php

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Movie\Repository\MovieRepository;
use App\Http\Controllers\Movie\Service\MovieService;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    public function __construct(
        protected MovieService    $service,
        protected MovieRepository $movieRepository
    ){}


    public function store(MovieRequest $request)
    {
        $movie = $this->service->create($request->validated());
        return new MovieResource($movie);
    }

    public function index()
    {
        $search = \request()->search ?? '';
        $movies = $this->movieRepository->all($search);
        return MovieResource::collection($movies);
    }

    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    public function update(MovieRequest $request, string $id)
    {
        $isUpdated = $this->service->update($id, $request->validated());
        return \response()->json(['data' => $isUpdated], Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
