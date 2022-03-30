<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->paginate(10);
        $categories = Category::all();
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $categories = Category::all();
        return view('admin.posts.create', compact('post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|unique:posts',
                'content' => ['required', 'string'],
                'image' => ['required', 'string'],
                'category_id' => 'nullable|exists:categories,id'
            ],
            [
                'title' => 'Il titolo è obbligatorio',
                'title' => "Esiste già un post dal titolo $request->title",
            ]
        );
        $data = $request->all();

        $data['slug'] = Str::slug($request->title, '-');
        $post = new Post();
        $post->fill($data);
        $post->save();

        return redirect()->route('admin.posts.index')->with('message', "$post->title Creato con successo")->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        return view('admin.posts.show', compact('post', $post->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title' => ['required', 'string', Rule::unique('posts')->ignore($post->id)],
                'content' => ['required', 'string'],
                'image' => ['required', 'string'],
                'category_id' => ['nullable', 'exists:categories,id']
            ],
            [
                'title' => 'Il titolo è obbligatorio',
                'title' => "Esiste già un post dal titolo $request->title",
            ]
        );
        $data = $request->all();
        $post->update($data);
        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $post->delete();
        return redirect()->route('admin.posts.index')->with('message', "$post->title Eliminato con successo")->with('type', 'success');
    }
}
