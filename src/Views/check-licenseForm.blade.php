@extends('vendor.mginstallable.layouts.master')

@section('template_title')
{{ trans('installer_messages.checkLicense.templateTitle') }}
@endsection

@section('title')
<i class="fa fa-magic fa-fw" aria-hidden="true"></i>
{!! trans('installer_messages.checkLicense.title') !!}
@endsection

@if ($error_message)
<span class="error-block">
    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
    {{ $error_message }}
</span>
@endif
@section('container')
<div class="tabs tabs-full">
    <form method="post" action="{{ route('mginstallable::checkLicense') }}" class="tabs-wrap">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
            <label for="app_name">
                {{ trans('installer_messages.checkLicense.form.app_name_label') }}
            </label>
            <input type="text" name="app_name" id="app_name" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
            @if ($errors->has('app_name'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('app_name') }}
            </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('app_key') ? ' has-error ' : '' }}">
            <label for="app_key">
                {{ trans('installer_messages.checkLicense.form.app_key') }}
            </label>
            <textarea name="app_key" id="app_key" value="" placeholder="{{ trans('installer_messages.checkLicense.form.app_key_placeholder') }}" >
            </textarea>
            @if ($errors->has('app_key'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('app_key') }}
            </span>
            @endif
        </div>
        <div class="buttons">
            <button class="button" type="submit">
                {{ trans('installer_messages.checkLicense.form.buttons.check') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection