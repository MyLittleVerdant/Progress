@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.about.edit', $aboutBlock))

@section('content')
    @include('admin.about._form', ['aboutBlock' => $aboutBlock])
@endsection

