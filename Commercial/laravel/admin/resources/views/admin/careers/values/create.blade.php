@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.careers.values.create'))

@section('content')
    @include('admin.careers.values._form')
@endsection

