@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.about.create'))

@section('content')
    @include('admin.about._form')
@endsection

