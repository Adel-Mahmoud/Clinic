@extends('layouts.master',["titlePage"=>$titlePage])
<x-page-header :titlePage="$titlePage" />

@section('content')
    <div>
        @livewire('reports.reports') 
    </div>
@endsection