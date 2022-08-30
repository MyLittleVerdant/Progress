@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.partners.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.partners.create') }}" class="btn btn-success float-right"><i
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
                        <th>Сайт партнёра</th>
                        <th>Цвет блока</th>
                        <th>Лого</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($partners as $partner)
                        <tr>
                            <td>{{ $partner->id }}</td>
                            <td>{{ $partner->sort }}</td>
                            <td>{{ $partner->name }}</td>
                            <td>{{ $partner->description }}</td>
                            <td>{{ $partner->link }}</td>
                            <td>{{ $partner->color }}</td>
                            <td>
                                @isset($partner->picture)
                                    <img src="{{$partner->picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.partners.delete', $partner) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-partner-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Партнёры не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $partners->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
