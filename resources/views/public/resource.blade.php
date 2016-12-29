@extends('layouts.wardrobe')

@section('head')
<title>{{ $pageName }} | Paralideres.org</title>
<link href="/static/{{ $appName }}/{{ $appName }}.css" rel="stylesheet" />
<script>
  window.__INITIAL_STATE__ = {!! json_encode($initialState) !!}
</script>
@endsection

@section('content')
<div id="root" class="app"></div>
<script src="/static/{{ $appName }}/{{ $appName }}.bundle.js"></script>
@endsection
