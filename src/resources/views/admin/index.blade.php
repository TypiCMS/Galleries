@extends('core::admin.master')

@section('title', __('galleries::global.name'))

@section('content')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'galleries'])

    <h1>@lang('galleries::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-persist="galleriesTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status" class="status st-sort">@lang('Status')</th>
                    <th st-sort="image" class="image st-sort">@lang('Image')</th>
                    <th st-sort="name" st-sort-default="true" class="name st-sort">@lang('Name')</th>
                    <th st-sort="title" class="title st-sort">@lang('Title')</th>
                    <th st-sort="files_count" class="files_count st-sort">@lang('Files')</th>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>
                        <input st-search="name" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="title" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'galleries'])
                    </td>
                    <td typi-btn-status action="toggleStatus(model)" model="model"></td>
                    <td>
                        <img ng-src="@{{ model.thumb }}" alt="">
                    </td>
                    <td>@{{ model.name }}</td>
                    <td>@{{ model.title }}</td>
                    <td typi-btn-files model="model"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
