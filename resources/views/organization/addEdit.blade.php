@section('title', isset($viewOrganization) ? 'Edit Organization' : 'Add Organization')
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
                            <h1>Organization {{isset($viewOrganization) ? 'Edit' : 'Add'}}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('organizations')}}" title="Organization Management">Organization Management</a></li>
                                <li class="breadcrumb-item active">{{isset($viewOrganization) ? 'Edit' : 'Add'}}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                <form method="POST" enctype="multipart/form-data"
                      action="{{ isset($viewOrganization) ? route('storeOrganization',$viewOrganization->id) : route('storeOrganization')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Organization</h3>
                                </div>
                                @if(isset($viewOrganization))
                                    <input type="hidden" id="id" name="id" value="{{$viewOrganization->id}}">
                                @endif
                                <input type="hidden" id="checkFormStatus"
                                       value="{{ isset($viewOrganization) ? 'edit' : 'insert'}}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name<span class="required">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ isset($viewOrganization) ? $viewOrganization->name : old('name') }}">
                                        <span class="error-msg">
                                          {{ $errors->first('name') }}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="categories">Category<span class="required">*</span></label>
                                        <select class="form-control valid" style="width: 100%;" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categoryList as $category)
                                                <option value="{{$category->id}}" {{  isset($viewOrganization) ? ($category->id === $viewOrganization->category_id ? 'selected' : '') : (old("category_id") == $category->id ? 'selected' : '') }}>{{$category->text}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-msg">
                                            {{ $errors->first('category_id')}}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="trade_license">Trade License<span class="required">*</span></label>
                                        <input type="text" name="trade_license" id="trade_license" class="form-control"
                                               value="{{ isset($viewOrganization) ? $viewOrganization->trade_license : old('trade_license') }}">
                                        <span class="error-msg">
                                          {{ $errors->first('trade_license') }}
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Logo</label>
                                        <input type="file" style="width: 100%;" id="logo" name="logo" accept="image/x-png,image/gif,image/jpeg">
                                        <span class="error-msg">
                                            {{ $errors->first('logo') }}
                                        </span>
                                        @if(isset($viewOrganization))
                                            @if (!empty($viewOrganization->logo) && file_exists(public_path('storage/upload/organization/images/'.$viewOrganization->logo)))
                                                <img class="img-thumbnail img-responsive" id="logo-tag" src="{{asset('storage/upload/organization/images')}}/{{$viewOrganization->logo}}">
                                            @else
                                                <img class="img-thumbnail img-responsive" id="logo-tag" src="{{url('images/no-image.png')}}">
                                            @endif
                                        @else
                                            <img class="img-thumbnail img-responsive" style="display: none;" id="logo-tag" src="{{url('images/no-image.png')}}">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="licensed_date">Licensed Date<span class="required">*</span></label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="licensed_date" placeholder="yyyy-mm-dd" name="licensed_date" value="{{ isset($viewOrganization) ? $viewOrganization->licensed_date : old('licensed_date') }}">
                                            <div class="input-group-addon">
                                            </div>
                                        </div>
                                        <span class="error-msg">
                                            {{ $errors->first('licensed_date') }}
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
                            <a href="{{route('organizations')}}" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="{{isset($viewOrganization) ? 'Update' : 'Add'}}" class="btn btn-primary float-right">
                        </div>
                    </div>
                </form>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
