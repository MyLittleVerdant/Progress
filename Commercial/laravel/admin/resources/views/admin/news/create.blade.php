@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.news.create'))

@section('content')
    @include('admin.news._form')
@endsection

