@extends("root")

@section("content")

{{-- header --}}
@include("components.header")

<h1>Ini Adalah Halaman Landing Page</h1>

{{-- form login --}}
@include("pages.components.login-form")

{{-- form register --}}
@include("pages.components.register-form")

{{-- footer --}}
@include("components.footer")

@endsection