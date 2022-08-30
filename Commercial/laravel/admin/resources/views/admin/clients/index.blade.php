@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.clients.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.clients.create') }}" class="btn btn-success float-right"><i
                        class="fa fa-plus"></i> Создать</a>
            </div>
            <div class="card-body">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Сортировка</th>
                        <th>Название</th>
                        <th>Лого</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->sort }}</td>
                            <td>{{ $client->name }}</td>
                            <td>
                                @isset($client->picture)
                                    <img src="{{$client->picture}}" width="140" height="50" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.clients.delete', $client) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-client-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Клиенты не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $clients->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
