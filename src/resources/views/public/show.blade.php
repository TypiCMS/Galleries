@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbAbsoluteSrc())

@section('main')

    @include('galleries::public._slider')

    <article>
        <h2>{{ $model->title }}</h2>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div class="body">{!! $model->body !!}</div>
    </article>

    @include('galleries::public._thumbs')

@stop
