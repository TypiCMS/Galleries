@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<ul class="nav nav-tabs">
    <li class="@if (Request::input('tab') != 'tab-files')active @endif">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li class="@if (Request::input('tab') == 'tab-files')active @endif">
        <a href="#tab-files" data-target="#tab-files" data-toggle="tab">@lang('global.Files')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in @if (Request::input('tab') != 'tab-files')active @endif" id="tab-main">

        {!! BootForm::text(trans('validation.attributes.name'), 'name') !!}

        @include('core::admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
                @include('core::form._title-and-slug')
                <input type="hidden" name="{{ $lang }}[status]" value="0">
                {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
                {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->rows(4) !!}
                {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('ckeditor') !!}
            </div>

            @endforeach

        </div>

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in @if (Request::input('tab') == 'tab-files')active @endif" id="tab-files">

        @if ($model->id)
            @include('galleries::admin.files')
        @else
            <p class="alert alert-info">@lang('galleries::global.Save your gallery, then add files.')</p>
        @endif

    </div>

</div>
