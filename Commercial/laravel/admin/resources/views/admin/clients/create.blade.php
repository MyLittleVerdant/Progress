@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.clients.create'))

@section('content')
    @include('admin.clients._form')
@endsection

