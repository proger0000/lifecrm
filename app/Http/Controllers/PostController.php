<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Отображение карты постов.
     */
    public function map()
{
    $posts = \App\Models\Post::all();
    return Inertia::render('Posts/Map', [
        'posts' => $posts,
    ]);
}
}
