@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.whales.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.whales.create') }}" class="btn btn-success float-right"><i
                        class="fa fa-plus"></i> Создать</a>
            </div>
            <div class="card-body">
                <table class="table table-hovered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ключ</th>
                        <th>Картинка</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($whales as $whale)
                        <tr>
                            <td>{{ $whale->id }}</td>
                            <td>{{ $whale->key }}</td>
                            <td>
                                @isset($whale->picture)
                                    <img src="{{$whale->picture}}" width="70" height="70" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.whales.edit', $whale) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.whales.delete', $whale) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-whale-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Киты не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $whales->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
