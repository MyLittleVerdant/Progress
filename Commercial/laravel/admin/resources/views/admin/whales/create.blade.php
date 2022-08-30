@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.whales.create'))

@section('content')
    @include('admin.whales._form')
@endsection

