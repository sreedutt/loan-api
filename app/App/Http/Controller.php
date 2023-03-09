<?php

namespace App\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function respondCreated(Transformer|array $data): JsonResponse
    {
        return response()->json(
            $data instanceof Transformer ? $data->transform() : $data,
            Response::HTTP_CREATED,
        );
    }
}
