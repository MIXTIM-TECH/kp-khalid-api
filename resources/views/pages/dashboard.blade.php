@extends("root")

@section("content")

{{-- sidebar --}}
@include("components.sidebar", $sidebar)

{{-- card --}}
@include("components.card")

{{-- graph --}}
@include("components.graph")

@endsection