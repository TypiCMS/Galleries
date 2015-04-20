@extends('core::public.master')

@section('title', trans('galleries::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('galleries::global.name'))
@section('bodyClass', 'body-galleries')

@section('main')

    <h1>@lang('galleries::global.name')</h1>

    @if ($models->count())
    @include('galleries::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
