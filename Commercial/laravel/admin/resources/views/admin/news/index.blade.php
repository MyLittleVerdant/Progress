@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.news.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.news.create') }}" class="btn btn-success float-right"><i
                        class="fa fa-plus"></i> Создать</a>
            </div>
            <div class="card-body">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок анонса</th>
                        <th>Дата</th>
                        <th>Описание анонса</th>
                        <th>Заглавная картинка</th>
                        <th>Картинка анонса</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->preview_title }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->preview_description}}</td>
                            <td>
                                @isset($item->main_picture)
                                    <img src="{{$item->main_picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                @isset($item->preview_picture)
                                    <img src="{{$item->preview_picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.news.delete', $item) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-news-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Новости не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $news->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
