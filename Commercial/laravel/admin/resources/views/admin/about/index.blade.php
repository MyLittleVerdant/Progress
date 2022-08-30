@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.about.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.about.create') }}" class="btn btn-success float-right"><i
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
                        <th>Подзаголовок</th>
                        <th>Описание</th>
                        <th>Картинка</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($about as $aboutBlock)
                        <tr>
                            <td>{{ $aboutBlock->id }}</td>
                            <td>{{ $aboutBlock->sort }}</td>
                            <td>{{ $aboutBlock->key }}</td>
                            <td>{{ $aboutBlock->title }}</td>
                            <td>{{ $aboutBlock->subtitle }}</td>
                            <td>{{ $aboutBlock->description }}</td>
                            <td>
                                @isset($aboutBlock->picture)
                                    <img src="{{$aboutBlock->picture}}" width="140" height="50" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.about.edit', $aboutBlock) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.about.delete', $aboutBlock) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-aboutBlock-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Блоки не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $about->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
