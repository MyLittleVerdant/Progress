@extends('layouts.app')
{{--@section('breadcrumbs', Breadcrumbs::render('admin.favours.edit', $favour))--}}

@section('content')
    @include('admin.favours._form', ['favour' => $favour])
@endsection

