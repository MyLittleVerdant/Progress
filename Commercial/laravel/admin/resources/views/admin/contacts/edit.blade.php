@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.contacts.edit', $contact))

@section('content')
    @include('admin.contacts._form', ['contact' => $contact])
@endsection

