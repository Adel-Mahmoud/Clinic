@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white fw-bold">
                سجل المريض : 
                {{ $patient_name }}
            </div>
            <div class="card-body">
                @livewire('examinations.patient-visits', ['patientId' => $id])
            </div>
        </div>
    </div>
</div>
@endsection