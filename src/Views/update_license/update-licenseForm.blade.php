@extends('vendor.mginstallable.layouts.master-update-license')

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
    <form method="post" action="{{ route('LicenseUpdater::update-license.check_update_license') }}" class="tabs-wrap">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group {{ $errors->has('app_domainName') ? ' has-error ' : '' }}">
            <label for="app_domainName">
                {{ trans('installer_messages.checkLicense.form.app_domainName_label') }}
            </label>
            <input type="text" name="app_domainName" id="app_domainName" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.app_domainName_placeholder') }}" />
            @if ($errors->has('app_domainName'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('app_domainName') }}
            </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
            <label for="email">
                {{ trans('installer_messages.checkLicense.form.email') }}
            </label>
            <input type="text" name="email" id="email" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.app_email_placeholder') }}" />
            @if ($errors->has('email'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('email') }}
            </span>
            @endif
        </div>
        <div class="buttons">
            <button class="button" type="submit">
                {{ trans('installer_messages.checkLicense.form.buttons.submit') }}
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