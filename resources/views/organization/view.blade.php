@section('title', 'View Organization')
@extends('layouts.common')

@section('content')

    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Organization View</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('organizations')}}" title="Organization Management">Organization Management</a></li>
                                <li class="breadcrumb-item active">View</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content view-detail">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Organization Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3" for="logo">Logo:</label>
                                @if (!empty($viewOrganization->logo) && file_exists(public_path('storage/upload/organization/images/'.$viewOrganization->logo)))
                                    <img class="img-thumbnail img-responsive" src="{{asset('storage/upload/organization/images')}}/{{$viewOrganization->logo}}">
                                @else
                                    <img class="img-thumbnail img-responsive" src="{{url('images/no-image.png')}}">
                                @endif
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputName">Name:</label>
                                <label class="col-sm-9" for="inputName">{{ $viewOrganization->name }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputName">Category:</label>
                                <label class="col-sm-9" for="inputName">{{ $viewOrganization->category->text }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputName">Trade License:</label>
                                <label class="col-sm-9" for="inputName">{{ $viewOrganization->trade_license }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputEmail">Licensed Date:</label>
                                <label class="col-sm-9" for="inputEmail">{{ $viewOrganization->licensed_date }}</label>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('organizations') }}" class="btn btn-secondary">Cancel</a>
                            <a href="{{ route('editOrganization',$viewOrganization->id) }}" class="btn btn-primary float-right">Edit Organization</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
