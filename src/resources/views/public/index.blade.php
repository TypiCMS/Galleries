@extends('pages::public.master')
<?php $page = TypiCMS::getPageLinkedToModule('galleries') ?>

@section('bodyClass', 'body-galleries body-galleries-index body-page body-page-' . $page->id)

@section('main')

    {!! $page->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('galleries::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
