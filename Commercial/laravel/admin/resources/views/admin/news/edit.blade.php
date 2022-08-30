@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.news.edit', $news))

@section('content')
    @include('admin.news._form', ['news' => $news])
@endsection

