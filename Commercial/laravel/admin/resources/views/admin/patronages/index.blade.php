@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.patronages.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.patronages.create') }}" class="btn btn-success float-right"><i
                        class="fa fa-plus"></i> Создать</a>
            </div>
            <div class="card-body responsive">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Сортировка</th>
                        <th>Заголовок</th>
                        <th>Описание анонса</th>
                        <th>Подробнее</th>
                        <th>Цвет блока</th>
                        <th>Картинка анонса</th>
                        <th>Детальная картинка</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($patronages as $patronage)
                        <tr>
                            <td>{{ $patronage->id }}</td>
                            <td>{{ $patronage->sort }}</td>
                            <td>{{ $patronage->name }}</td>
                            <td>{{ $patronage->preview_description }}</td>
                            <td>{{ $patronage->link }}</td>
                            <td>{{ $patronage->color }}</td>
                            <td>
                                @isset($patronage->preview_picture)
                                    <img src="{{$patronage->preview_picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                @isset($patronage->detail_picture)
                                    <img src="{{$patronage->detail_picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.patronages.edit', $patronage) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.patronages.delete', $patronage) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-patronage-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Меценаты не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $patronages->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
