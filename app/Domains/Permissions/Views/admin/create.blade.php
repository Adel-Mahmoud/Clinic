@extends('layouts.master',["titlePage"=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<livewire:permissions.create-permission />
@endsection


