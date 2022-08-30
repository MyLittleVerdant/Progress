@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.partners.create'))

@section('content')
    @include('admin.partners._form')
@endsection

