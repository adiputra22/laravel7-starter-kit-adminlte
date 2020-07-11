@extends('layouts.app')

@section('style_content')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Permissions Page') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">{{ __('Permission') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Edit Permission') }}</h3>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('admin.permissions.update', ['permissionId' => $permission->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" name="id" value="{{ $permission->id }}" />
                                    <input type="text" class="form-control" name="name" value="{{ $permission->name }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-sm-2 col-form-label">{{ __('Role') }}</label>
                                <div class="col-sm-10">
                                    @if($permission->roles()->count() > 0)
                                        <select class="form-control select2" multiple="multiple" id="role" name="role[]" placeholder="{{ __('Role') }}" style="width: 100%;">
                                            @foreach($roles as $role)
                                                @php
                                                    $isSelected = false;
                                                @endphp
                                                @foreach($permission->roles()->get() as $rolePermission)
                                                    @if($rolePermission->id == $role->id) 
                                                        @php 
                                                            $isSelected = true;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                <option value="{{ $role->id }}" @if($isSelected) selected="selected" @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control select2" multiple="multiple" id="role" name="role[]" placeholder="{{ __('Role') }}" style="width: 100%;">
                                            <option value=""></option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">{{ __('Save') }}</button>
                            <button type="button" class="btn btn-default float-right">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js_content')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });
    });
</script>
@endsection