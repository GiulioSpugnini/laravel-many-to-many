@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-{{ session('type') }}">
                {{ session('message') }}
            </div>
        @endif
        <header class="d-flex justify-content-between align-items-center">
            <h2>I miei Posts</h2>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary"> <i class="fa fa-plus mr-2"></i> Aggiungi
                post</a>
        </header>
        <div>
            <table class="table table-success">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titolo:</th>
                        <th scope="col">Tags:</th>
                        <th scope="col">Categorie:</th>
                        <th scope="col">Data di crezione:</th>
                        <th scope="col">Azione</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>
                                @if (count($post->tags))
                                    @foreach ($post->tags as $tag)
                                        <span class="rounded p-1"
                                            style="background-color:{{ $tag->color }}">{{ $tag->label }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif

                            </td>
                            <td>
                                @if ($post->category)
                                    <span
                                        class="badge badge-pill badge-{{ $post->category->color }}">{{ $post->category->label }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $post->created_at }}</td>
                            <th class="d-flex justify-content-end align-items-center">
                                <a class="btn btn-sm btn-primary mr-2"
                                    href="{{ route('admin.posts.show', $post->id) }}"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-sm btn-warning mr-2"
                                    href="{{ route('admin.posts.edit', $post->id) }}"><i class="fas fa-pencil"></i></a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i
                                            class="fas fa-trash-alt"></i></button>

                                </form>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="">
                                <h3>Non ci sono post</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($posts->hasPages())
        <div class="d-flex justify-content-end align-items-center">
            {{ $posts->links() }}
        </div>
    @endif

    <div class="row">
        @foreach ($categories as $category)
            <div class="col-3 mb-2">
                <h3>{{ $category->label }}</h3>
                @foreach ($category->posts as $post)
                    <h5><a href="{{ route('admin.posts.show', $post->id) }}">{{ $post->title }}</a></h5>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

@section('additional-script')
    <script>
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const accept = confirm('Sei sicuro di voler cancellare questo post?');
                if (accept) e.target.submit();
            })
        })
    </script>
@endsection
