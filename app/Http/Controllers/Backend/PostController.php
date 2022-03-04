<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\NoReturn;

use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $posts = Post::latest()->get();

        return view('posts.index', compact($posts));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return RedirectResponse
     */
    #[NoReturn] public function store(PostRequest $request): RedirectResponse
    {
        dd($request->all());
        // Salvar
        $post = Post::created([
            'user_id' => auth()-user()->id
    ] + $request->all());

        //image
        if($request->file()) {
            $post->image = $request->file('file')->store('posts', 'public');
            $post->save();
        }

        //Retornar
        return back()->with('status', 'Creado con exito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Application|Factory|View
     */
    public function edit(Post $post): Application|Factory|View
    {
        //
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param Post $post
     * @return Response
     */
    public function update(PostRequest $request, Post $post): Response
    {
        $post->update($request->all());

        if($request->file('file')) {
            Storage::disk('public')->delete($post->image);
            $post->image = $request->file('file')->store('posts', 'public');
            $post->save();
        }

        return back()->with('status', 'actualizando con exito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post): Response
    {
        Storage::disk('public')->delete($post->image);
        $post->delete();

        return back()->with('status', 'Eliminado con exito');
    }
}
