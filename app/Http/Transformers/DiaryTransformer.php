<?php

namespace App\Http\Transformers;

use App\Models\Diary;
use League\Fractal\TransformerAbstract;

class DiaryTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Diary $diary)
    {
        $data = $diary->attributesToArray();

        isset($data['images']) && $data['images'] = (array) $data['images'];

        return $data;
    }

    public function includeUser(Diary $diary)
    {
        return $this->item($diary->user, new UserTransformer());
    }
}