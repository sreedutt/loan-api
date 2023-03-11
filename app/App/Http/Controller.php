<?php

namespace App\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function respond(array $data, $status): JsonResponse
    {
        return response()->json($data, $status);
    }
    public function respondCreated(Transformer $transformer, $model): JsonResponse
    {
        return $this->respond($transformer->transform($model), Response::HTTP_CREATED);
    }

    public function respondOk(Transformer $transformer, $model): JsonResponse
    {
        return $this->respond($transformer->transform($model), Response::HTTP_OK);
    }

    public function respondWithPaginatedCollection(Transformer $transformer, LengthAwarePaginator $collection): JsonResponse
    {
        $collection->transform(
            fn ($item) => $transformer->transform($item)
        );

        return $this->respond([
            'data' => $collection->items(),
            'pagination' => [
                'current_page' => $collection->currentPage(),
                'last_page' => $collection->lastPage(),
                'per_page' => $collection->perPage(),
                'total' => $collection->total(),
            ]
        ], Response::HTTP_OK);
    }
}
