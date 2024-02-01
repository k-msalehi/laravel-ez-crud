@php
echo "@extends('layouts.app')\n";
echo "@section('title','Create {$modelName}')\n";
echo "@section('content')\n";
@endphp
<h1 class="">Create {{$modelName}}</h1>
<div class="my-3">
    {!! $form !!}
</div>
@php
echo "@endsection";
@endphp