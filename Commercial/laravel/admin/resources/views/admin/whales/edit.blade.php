@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.whales.edit', $whale))

@section('content')
    @include('admin.whales._form', ['whale' => $whale])
@endsection

