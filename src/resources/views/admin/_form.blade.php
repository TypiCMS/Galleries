@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@component('core::admin._buttons-form', ['model' => $model])
    @if ($model->id)
    <button class="btn btn-success" type="submit">{{ __('Add files') }}</button>
    @endif
@endcomponent

{!! BootForm::hidden('id') !!}

<ul class="nav nav-tabs">
    <li class="@if (request('tab') != 'tab-files')active @endif">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('Content')</a>
    </li>
    <li class="@if (request('tab') == 'tab-files')active @endif">
        <a href="#tab-files" data-target="#tab-files" data-toggle="tab">@lang('Files')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in @if(request('tab') != 'tab-files')active @endif" id="tab-main">

        @include('core::admin._image-fieldset', ['field' => 'image'])

        {!! BootForm::text(__('Name'), 'name') !!}

        @include('core::form._title-and-slug')
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in @if(request('tab') == 'tab-files')active @endif" id="tab-files">

        @if ($model->id)
            @include('galleries::admin.files')
        @else
            <p class="alert alert-info">@lang('galleries::global.Save your gallery, then add files.')</p>
        @endif

    </div>

</div>
