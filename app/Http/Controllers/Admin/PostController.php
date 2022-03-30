<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Tag;

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
        $tags = Tag::orderBy('label', 'ASC')->get();
        $categories = Category::all();
        return view('admin.posts.index', compact('posts', 'categories', 'tags'));
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
        $tags = Tag::orderBy('label', 'ASC')->get();
        return view('admin.posts.create', compact('post', 'categories', 'tags'));
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
                'category_id' => 'nullable|exists:categories,id',
                'tags' => 'nullable|exists:tags,id'
            ],
            [
                'title' => 'Il titolo è obbligatorio',
                'title' => "Esiste già un post dal titolo $request->title",
                'tags' => 'Un tag di quelli selezionati non è valido'
            ]
        );
        $data = $request->all();

        $data['slug'] = Str::slug($request->title, '-');
        $post = new Post();
        $post->fill($data);
        $post->save();
        //Se in data esiste una array allora aggancio i tags
        if (array_key_exists('tags', $data)) $post->tags()->attach($data['tags']);

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
        $tags = Tag::orderBy('label', 'ASC')->get();
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
        $tags = Tag::all();
        $tags_checked = $post->tags->pluck('id')->toArray();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'tags_checked'));
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
                'category_id' => ['nullable', 'exists:categories,id'],
                'tags' => 'nullable|exists:tags,id'
            ],
            [
                'title' => 'Il titolo è obbligatorio',
                'title' => "Esiste già un post dal titolo $request->title",
                'tags' => 'Un tag di quelli selezionati non è valido'
            ]
        );
        $data = $request->all();
        $post->update($data);

        if (!array_key_exists('tags', $data)) $post->tags()->detach($data['tags']);
        else $post->tags()->sync($data['tags']);
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
