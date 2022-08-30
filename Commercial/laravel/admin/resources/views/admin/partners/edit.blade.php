@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.partners.edit', $partner))

@section('content')
    @include('admin.partners._form', ['partner' => $partner])
@endsection

