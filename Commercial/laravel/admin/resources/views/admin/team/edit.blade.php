@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.team.edit', $member))

@section('content')
    @include('admin.team._form', ['member' => $member])
@endsection

