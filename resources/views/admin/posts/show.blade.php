@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-center algin-items-center">
        <div class="card mb-3 p-2" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex align-items-baseline">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            @if ($post->category)
                                <span
                                    class="ml-2 badge badge-pill badge-{{ $post->category->color }}">{{ $post->category->label }}</span>
                            @endif
                        </div>

                        <p class="card-text">{{ $post->content }}</p>
                        <div class="d-flex justify-content-start align-items-center">
                            @if ($post->tags)
                                @foreach ($post->tags as $tag)
                                    <div class="rounded m-1 p-2" style="background-color:{{ $tag->color }}">
                                        {{ $tag->label }}</div>
                                @endforeach
                            @else
                                <h5>Nessun tag</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- BUTTONS --}}
            <div class="d-flex justify-content-end align-items-center my-2">
                <a class="btn btn-secondary mr-2" href="{{ route('admin.posts.index') }}" type="button"
                    class="btn btn-success">
                    Indietro
                </a>
                <a class="btn btn btn-warning mr-2" href="{{ route('admin.posts.edit', $post->id) }}">Modifica</a>
                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger mr-2" type="submit">Elimina</button>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('additional-script')
    <script>
        const deleteForms = document.querySelector('.delete-form');
        deleteForms.addEventListener('submit', (e) => {
            e.preventDefault();
            const accept = confirm('Sei sicuro di voler cancellare questo post?');
            if (accept) e.target.submit();
        });
    </script>
@endsection
