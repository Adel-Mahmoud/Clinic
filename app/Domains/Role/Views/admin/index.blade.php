@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :titlePage="$titlePage" />

@section('content')
<livewire:role.role-index />
@endsection
