@extends('layouts.master',['titlePage'=>$titlePage ?? 'المرضى'])
<x-page-header :titlePage="$titlePage ?? 'المرضى'" />

@section('content')
<livewire:patients.patient-index />
@endsection 