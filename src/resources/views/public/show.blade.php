@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbAbsoluteSrc())
@section('bodyClass', 'body-gallery body-gallery-' . $model->id)

@section('main')

    @include('galleries::public._slider')

    @include('core::public._btn-prev-next', ['module' => 'Galleries', 'model' => $model])
    <article>
        <h1>{{ $model->title }}</h1>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div class="body">{!! $model->body !!}</div>
    </article>

    @include('galleries::public._thumbs')

@stop
