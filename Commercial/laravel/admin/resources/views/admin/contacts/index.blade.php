@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.contacts.index'))
@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.contacts.create') }}" class="btn btn-success float-right"><i
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
                        <th>Данные</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->sort }}</td>
                            <td>{{ $contact->key }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->data }}</td>
                            <td>
                                <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i> Редактировать</a>
                                <form action="{{ route('admin.contacts.delete', $contact) }}" method="POST"
                                      class="d-inline delete-position-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="delete-contact-btn btn btn-danger"><i class="fa fa-trash"></i>
                                        Удалить</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Контакты не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $contacts->links('admin.includes.pagination') }}
            </div>
        </div>
    </section>
@endsection
