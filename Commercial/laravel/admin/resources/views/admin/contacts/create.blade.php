@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.contacts.create'))

@section('content')
    @include('admin.contacts._form')
@endsection

