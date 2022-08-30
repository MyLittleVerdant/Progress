@extends('layouts.app')
{{--@section('breadcrumbs', Breadcrumbs::render('admin.favours.index'))--}}
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.favours.create') }}" class="btn btn-success float-right"><i
                        class="fa fa-plus"></i> Создать</a>
            </div>
            <div class="card-body">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Сортировка</th>
                        <th>Ключ</th>
                        <th>Заголовок</th>
                        <th>Описание</th>
                        <th>Подробнее</th>
                        <th>Превью фото</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($favours as $favour)
                        <tr>
                            <td>{{ $favour->id }}</td>
                            <td>{{ $favour->sort }}</td>
                            <td>{{ $favour->key }}</td>
                            <td>{{ $favour->title }}</td>
                            <td>{{ $favour->description}}</td>
                            <td>{{ $favour->link}}</td>
                            <td>
                                @isset($favour->preview_picture)
                                    <img src="{{$favour->preview_picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.favours.edit', $favour) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.favours.delete', $favour) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-favour-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Услуги не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $favours->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
