@php
echo "@extends('layouts.app')\n";
echo "@section('title','Create {$modelName}')\n";
echo "@section('content')\n";
@endphp
<h1 class="">Edit {{$modelName}}</h1>
<div class="my-3">
    {{$modelName}}
    {!! $form !!}
</div>
@php
echo "@endsection";
@endphp