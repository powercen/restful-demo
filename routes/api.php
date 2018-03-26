<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function ($api) {
    \Illuminate\Support\Facades\Auth::login(\App\Models\User::find(1));

    $api->resource('users', 'UserController');
    $api->resource('diaries', 'DiaryController');
    $api->resource('goals', 'GoalController');
    $api->resource('categories', 'CategoryController');

    //点赞日记与取消点赞日记
    $api->post('diaries/{diaries}/likes', 'DiaryLikeController@store');
    $api->delete('diaries/{diaries}/likes', 'DiaryLikeController@destroy');


    // 嵌套资源处理
    $api->get('goals/{goal}/diaries', function ($id) {
        $goal = \App\Models\Goal::findOrFail($id);
        return app(\App\Http\Controllers\Api\DiaryController::class)->index($goal->diaries());
    });

    $api->get('users/{user}/diaries', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        return app(\App\Http\Controllers\Api\DiaryController::class)->index($user->diaries());
    });
    $api->get('users/{user}/goals', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        return app(\App\Http\Controllers\Api\GoalController::class)->index($user->goals());
    });

    $api->get('categories/{category}/goals', function ($id) {
        $category = \App\Models\Category::findOrFail($id);
        return app(\App\Http\Controllers\Api\GoalController::class)->index($category->goals());
    });
    $api->get('categories/{category}/diaries', function ($id) {
        $category = \App\Models\Category::findOrFail($id);
        return app(\App\Http\Controllers\Api\DiaryController::class)->index($category->diaries());
    });
    $api->get('categories/{category}/users', function ($id) {
        $category = \App\Models\Category::findOrFail($id);
        return app(\App\Http\Controllers\Api\UserController::class)->index($category->users());
    });
});