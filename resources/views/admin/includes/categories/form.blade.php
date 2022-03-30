@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif
@if ($category->exists)
    <form class="my-3" action="{{ route('admin.categories.update', $category->id) }}" method="POST"
        novalidate>
        @method('PUT')
    @else
        <form class="my-3" action="{{ route('admin.categories.store') }}" method="POST" novalidate>
@endif
@csrf
<div class="row gy-2">
    <div class="col-6">
        <label for="label" class="form-label">Label</label>
        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label"
            value="{{ old('label', $category->label) }}">
        @error('label')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-6">
        <label for="color" class="form-label">Colore</label>
        <select class="form-control @error('color') is-invalid @enderror" id="color" name="color">
            <option value="success" @if (old('color', $category->color) === 'success') selected @endif>Verde</option>
            <option value="light" @if (old('color', $category->color) === 'light') selected @endif>Bianco</option>
            <option value="info" @if (old('color', $category->color) === 'info') selected @endif>Celeste</option>
            <option value="primary" @if (old('color', $category->color) === 'primary') selected @endif>Azzurro</option>
            <option value="danger" @if (old('color', $category->color) === 'danger') selected @endif>Rosso</option>
            <option value="warning" @if (old('color', $category->color) === 'warning') selected @endif>Giallo</option>
        </select>
        @error('color')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


</div>

<div class="d-flex justify-content-end align-items-center my-3">
    <a class="btn btn-secondary mr-2" href="{{ route('admin.categories.index') }}" type="button"
        class="btn btn-success">
        Indietro
    </a>
    <button type="submit" class="btn btn-success">
        Conferma
    </button>
</div>

</form>
