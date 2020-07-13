@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Users Page') }}</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Lists User') }}</h3>

                        <div class="card-tools">
                            <form action="{{ route('admin.users.index') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="{{ __('Search') }}" value="{{ request()->get('search') }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <a class='btn btn-info mb-2' href="{{ route('admin.users.create') }}">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td>{{ __('Name') }}</td>
                                <td>{{ __('Email') }}</td>
                                <td>{{ __('Role') }}</td>
                                <td>{{ __('Actions') }}</td>
                            </tr>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles()->get()->pluck('name')->implode('-') }}</td>
                                <td>
                                    <a class='btn btn-info m-1' href="{{ route('admin.users.edit', ['userId' => $user->id]) }}">
                                        <i class="fas fa-pen"></i> {{ __('Edit') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal_content')
    @include('common.index-modal-alert');
@endsection
