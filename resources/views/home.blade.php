@extends('layout.default')
@section('title', config('app.name'))

@section('content')

    @include('shared.banner')

    @include('shared.whyus')

    @include('shared.howitworks')

    @include('shared.testimonials') 

    @include('shared.pricingplan')

    @include('shared.contactus')

@endsection