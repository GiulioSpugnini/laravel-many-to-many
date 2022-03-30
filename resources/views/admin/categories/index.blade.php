@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-{{ session('type') }}">
                {{ session('message') }}
            </div>
        @endif
        <header class="d-flex justify-content-between align-items-center">
            <h2>Categorie</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"> <i class="fa fa-plus mr-2"></i>
                Aggiungi
                Categoria</a>
        </header>
        <div>
            <table class="table table-success">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome:</th>
                        <th scope="col">Colore:</th>


                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->label }}</td>
                            <td>{{ $category->color }}</td>

                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <th class="d-flex justify-content-end align-items-center">
                                <a class="btn btn-sm btn-primary mr-2"
                                    href="{{ route('admin.categories.show', $category->id) }}"><i
                                        class="fas fa-eye"></i></a>
                                <a class="btn btn-sm btn-warning mr-2"
                                    href="{{ route('admin.categories.edit', $category->id) }}"><i
                                        class="fas fa-pencil"></i></a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i
                                            class="fas fa-trash-alt"></i></button>

                                </form>
                            </th>
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
