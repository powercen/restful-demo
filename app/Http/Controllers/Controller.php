<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    use Helpers, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function parseFilter($query, $where = [])
    {
        //排序
        $query->orderBy(request()->get('sort_by', 'id'), request()->get('order', 'desc'));

        //字段限制
        !is_null(request()->get('fields')) && $query->addSelect(explode(',', request()->get('fields')));

        //筛选条件
        foreach ($where as $item) {
            if (is_null($value = request()->get($item))) {
                continue;
            }

            // 关键字逗号不允许随意使用
            if (str_contains($value, ',')) {
                $query->whereIn($item, explode(',', $value));
            } else {
                $query->where($item, '=', $value);
            }
        }


        //分页
        return $query->paginate(request()->get('pre_page', 15))->appends(request()->except('page'));
    }
}
