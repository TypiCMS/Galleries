@extends('core::public.master')

@section('title', trans('galleries::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('galleries::global.name'))

@section('main')

    <h2>@lang('galleries::global.name')</h2>

    @if ($models->count())
    <ul>
        @foreach ($models as $model)
        <li>
            <strong>{{ $model->title }}</strong>
            <div class="date">{{ $model->present()->dateFromTo }}</div>
            <a href="{{ route($lang.'.galleries.slug', $model->slug) }}">@lang('db.More')</a>
        </li>
        @endforeach
    </ul>
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
