@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.careers.values.edit', $value))

@section('content')
    @include('admin.careers.values._form', ['value' => $value])
@endsection

