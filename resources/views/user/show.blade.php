@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Users Page') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('User') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Show') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Show User') }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.users.edit',["userId" => $user->id]) }}" class="btn btn-info">
                            <i class="fas fa-pen"></i> {{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('User Roles') }}</h3>
                    </div>
                <form class="form-horizontal" method="POST" action="{{ route('admin.users.roles.update',['userId' => $user->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <table class="table table-bordered">
                            @foreach ($roles as $item)

                                @php $status = false; @endphp

                                @foreach($currentUserRoles as $currentRole)
                                    @if($currentRole->id == $item->id)
                                        @php
                                            $status = true;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach

                                <tr>
                                    <td><input name="role[]" type="checkbox" value="{{ $item->name }}" @if($status) checked="checked" @endif></td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">{{ __('Save') }}</button>
                        <button type="button" class="btn btn-default float-right">{{ __('Back To List') }}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
