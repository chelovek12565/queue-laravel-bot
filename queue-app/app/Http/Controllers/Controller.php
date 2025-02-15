<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function pagination(LengthAwarePaginator $paginator, $data = null): JsonResponse
    {
        return $this->asJson([
            'success'    => true,
            'data'       => $data ?: $paginator->items(),
            'pagination' => [
                'currentPage'  => $paginator->currentPage(),
                'lastPage'     => $paginator->lastPage(),
                'firstPageUrl' => $paginator->url(1),
                'lastPageUrl'  => $paginator->url($paginator->lastPage()),
                'nextPageUrl'  => $paginator->nextPageUrl(),
                'prevPageUrl'  => $paginator->previousPageUrl(),
                'perPage'      => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }

    protected function asJson($data = [], $status = 200, array $headers = [], $options = 0): JsonResponse
    {
        return response()->json($data, $status, $headers, $options);
    }
}
