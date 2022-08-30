@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.careers.index'))
@section('content')
    <section class="content">

        <form action="{{ route('admin.careers.update', $career) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="post">Главное описание</label>
                    <textarea name="description" id="editor" cols="40" rows="5"
                              class="form-control @error('description') is-invalid @enderror">
                        {{ old('description', isset($career) ? $career->description : '') }}
                </textarea>
                    @error('description')
                    <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ 'Обновить' }}</button>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.careers.values.create') }}" class="btn btn-success float-right"><i
                        class="fa fa-plus"></i> Создать</a>
            </div>
            <div class="card-body">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Сортировка</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Картинка</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($values as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->sort }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->description }}</td>
                            <td>
                                @isset($value->picture)
                                    <img src="{{$value->picture}}" width="140" height="50" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.careers.values.edit', $value) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.careers.values.delete', $value) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-career_value-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Ценности не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $values->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
