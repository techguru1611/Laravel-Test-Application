@section('title', isset($viewContact) ? 'Edit Organization' : 'Add Organization')
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
                            <h1>Contact {{isset($viewContact) ? 'Edit' : 'Add'}}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('contact')}}" title="Contact Management">Contact Management</a></li>
                                <li class="breadcrumb-item active">{{isset($viewContact) ? 'Edit' : 'Add'}}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                <form method="POST" enctype="multipart/form-data" id="formData"
                      action="{{ isset($viewContact) ? route('storeContact',$viewContact->id) : route('storeContact')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Contact</h3>
                                </div>
                                @if(isset($viewContact))
                                    <input type="hidden" id="id" name="id" value="{{$viewContact->id}}">
                                @endif
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="first_name">First Name<span class="required">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                               value="{{ isset($viewContact) ? $viewContact->first_name : old('first_name') }}">
                                        <span class="error-msg">
                                          {{ $errors->first('first_name') }}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name<span class="required">*</span></label>
                                        <input type="text" name="last_name" id="last_name" class="form-control"
                                               value="{{ isset($viewContact) ? $viewContact->last_name : old('last_name') }}">
                                        <span class="error-msg">
                                          {{ $errors->first('last_name') }}
                                        </span>
                                    </div>
                                    <div class="form-group" id="field_div">
                                        <label for="mobile_numbers">Mobile Numbers<span class="required">*</span></label>
                                        @if(isset($viewContact))
                                            @foreach(json_decode($viewContact->mobile_numbers) as $key => $no)
                                            <div class="row" style="margin-top: 5px">
                                                <input type="text" name="mobile_numbers[]" class="form-control col-sm-8"
                                                    value="{{ isset($no) ? $no : old('no') }}" required> 
                                                @if($key > 0)
                                                <a href="javascript(void);"  style="margin-left: 50px" class="remove_this btn btn-danger">Remove</a>
                                                @else
                                                <button style="margin-left: 50px" class="btn btn-primary" type="button" id="append" name="append">Add</button>
                                                @endif
                                            </div>
                                            @endforeach
                                        @else 
                                            <div class="row">
                                                <input type="text" name="mobile_numbers[]" class="form-control col-sm-8"
                                                    value="" required> 
                                                <button style="margin-left: 50px" class="btn btn-primary" type="button" id="append" name="append">Add</button>
                                            </div>
                                        @endif
                                        <span class="error-msg">
                                          {{ $errors->first('mobile_numbers') }}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email<span class="required">*</span></label>
                                        <input type="text" name="email" id="email" class="form-control"
                                               value="{{ isset($viewContact) ? $viewContact->email : old('email') }}">
                                        <span class="error-msg">
                                          {{ $errors->first('email') }}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="organization">Organization<span class="required">*</span></label>
                                        <select class="form-control valid" style="width: 100%;" id="category_id" name="organization_id">
                                            <option value="">Select Organization</option>
                                            @foreach($organizationList as $organization)
                                                <option value="{{$organization->id}}" {{  isset($viewContact) ? ($organization->id === $viewContact->organization_id ? 'selected' : '') : (old("organization_id") == $organization->id ? 'selected' : '') }}>{{$organization->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-msg">
                                            {{ $errors->first('organization_id')}}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth<span class="required">*</span></label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="dob" placeholder="yyyy-mm-dd" name="dob" value="{{ isset($viewContact) ? $viewContact->dob : old('dob') }}">
                                            <div class="input-group-addon">
                                            </div>
                                        </div>
                                        <span class="error-msg">
                                            {{ $errors->first('dob') }}
                                        </span>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{route('contact')}}" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="{{isset($viewContact) ? 'Update' : 'Add'}}" class="btn btn-primary float-right">
                        </div>
                    </div>
                </form>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
