@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.team.create'))

@section('content')
    @include('admin.team._form')
@endsection

