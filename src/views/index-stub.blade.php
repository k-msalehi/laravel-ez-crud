@php
echo "@extends('layouts.app')\n";
echo "@section('title','Create {$modelName}')\n";
echo "@section('content')\n";
@endphp
<h1 class="">{{$pluralModelName}} list</h1>
<div class="my-3">
    {!! $table !!}
</div>
@php
echo "@endsection";
@endphp