@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.clients.edit', $client))

@section('content')
    @include('admin.clients._form', ['client' => $client])
@endsection

