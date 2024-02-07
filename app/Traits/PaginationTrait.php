<?php
namespace App\Traits;

trait PaginationTrait
{

    public function makeMetaData($data): array
    {
        if (!isset($data)) {
            return null;
        }
        return [
            'total'=>$data->total(),
            'count'=>$data->count(),
            'pagination'=>$data->perPage(),
            'page'=>$data->currentPage(),
            'lastPage'=>$data->lastPage(),
            'hasMorePages'=>$data->hasMorePages(),
            'nextPageUrl'=>$data->nextPageUrl(),
            'previousPageUrl'=>$data->previousPageUrl(),
            '_links' => $data->getUrlRange(1, $data->lastPage())
        ];
    }
}
