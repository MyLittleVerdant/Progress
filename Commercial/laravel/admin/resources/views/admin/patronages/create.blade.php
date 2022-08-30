@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.patronages.create'))

@section('content')
    @include('admin.patronages._form')
@endsection

