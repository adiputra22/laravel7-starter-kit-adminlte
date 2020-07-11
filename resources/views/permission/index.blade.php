@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Permissions Page') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('Permission') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Index') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Lists Permission') }}</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="{{ __('Search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="float-right">
                            <a class='btn btn-info mb-2' href="{{ route('admin.permissions.create') }}">
                                <i class="fas fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td>{{ __('Name') }}</td>
                                <td>{{ __('Roles') }}</td>
                                <td>{{ __('Actions') }}</td>
                            </tr>
                            @foreach($permissions as $index => $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->roles()->get()->pluck('name')->implode(', ') }}</td>
                                <td>
                                    <a class='btn btn-info m-1' href="{{ route('admin.permissions.edit', ['permissionId' => $item->id]) }}">
                                        <i class="fas fa-pen"></i> {{ __('Edit') }}
                                    </a>
                                    <a class='btn btn-danger m-1' href="{{ route('admin.permissions.delete', ['permissionId' => $item->id]) }}" data-href="{{ route('admin.permissions.delete', ['permissionId' => $item->id]) }}" data-toggle="modal" data-target="#delete-modal">
                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $permissions->links() }}
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