@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif
@if ($post->exists)
    <form class="my-3" action="{{ route('admin.posts.update', $post->id) }}" method="POST" novalidate>
        @method('PUT')
    @else
        <form class="my-3" action="{{ route('admin.posts.store') }}" method="POST" novalidate>
@endif
@csrf
<div class="row gy-2">
    <div class="col-6">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
            value="{{ old('title', $post->title) }}">
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-6">
        <label for="category" class="form-label">Categoria</label>
        <select class="form-control @error('category_id') is-invalid @enderror" id="category" name="category_id"
            value="{{ old('category', $post->category) }}">
            <option value="">Nessuna Categoria</option>
            @foreach ($categories as $category)
                <option @if (old('category_id', $post->category_id) == $category->id) selected @endif value="{{ $category->id }}">
                    {{ $category->label }}</option>
            @endforeach
        </select>

        @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-6">
        <label for="image" class="form-label">Url dell'immagine</label>
        <input type="url" class="form-control" id="image" name="image" value="{{ old('image', $post->image) }}">
    </div>

    <div class="col-12 text-center">
        <div class="mb-3">
            <label for="content" class="form-label">Contenuto</label>
            <textarea class="form-control" id="content" rows="5" name="content">{{ old('content', $post->content) }}</textarea>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end align-items-center">
    <a class="btn btn-secondary mr-2" href="{{ route('admin.posts.index') }}" type="button" class="btn btn-success">
        Indietro
    </a>
    <button type="submit" class="btn btn-success">
        Conferma
    </button>
</div>

</form>
