@extends('layouts.wardrobe')

@section('head')
<title>{{ $pageName }} | Paralideres.org</title>
<link href="/static/{{ $appName }}/{{ $appName }}.css" rel="stylesheet" />
@endsection

@section('content')
<div id="root" class="app"></div>
<script src="/static/{{ $appName }}/{{ $appName }}.bundle.js"></script>
@endsection
