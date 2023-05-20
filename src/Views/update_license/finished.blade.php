@extends('vendor.mginstallable.layouts.master-update-license')

@section('title', trans('installer_messages.updater.final.title'))
@section('container')
<p class="paragraph text-center">{{ session('message')['message'] }}</p>
<div class="buttons">
    <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.updater.final.exit') }}</a>
</div>
@stop