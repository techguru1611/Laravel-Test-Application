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
                                <label class="col-sm-3" for="inputName">First Name:</label>
                                <label class="col-sm-9" for="inputName">{{ $viewContact->first_name }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputName">Last Name:</label>
                                <label class="col-sm-9" for="inputName">{{ $viewContact->last_name }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputName">Mobile Numbers:</label>
                                <label class="col-sm-9" for="inputName">{{ implode(',',json_decode($viewContact->mobile_numbers)) }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputEmail">Email:</label>
                                <label class="col-sm-9" for="inputEmail">{{ $viewContact->email }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputphone">Organization:</label>
                                <label class="col-sm-9" for="inputphone">{{ $viewContact->organization->name }}</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="inputphone">Date of Birth:</label>
                                <label class="col-sm-9" for="inputphone">{{ $viewContact->dob }}</label>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('contact') }}" class="btn btn-secondary">Cancel</a>
                            <a href="{{ route('editContact',$viewContact->id) }}" class="btn btn-primary float-right">Edit Contact</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
