@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.patronages.edit', $patronage))

@section('content')
    @include('admin.patronages._form', ['patronage' => $patronage])
@endsection

