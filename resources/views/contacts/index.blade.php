@section('title', 'Contact Management')
@extends('layouts.common')

@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Contact Management</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @if(session()->has('msg'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <strong>Success!</strong> {{ session()->get('msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                           
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <form action="{{route('contact')}}" method="GET">
                                            <div class="input-group input-group-sm" style="width: 250px;">
                                                <input type="text" name="search" class="form-control float-right search"
                                                       placeholder="Search" value="{{$search}}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default"><i
                                                            class="fas fa-search"></i></button>
                                                </div>
                                             
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{route('addViewContact')}}" class="btn btn-primary float-right"><i
                                                class="fas fa-plus"></i> Add Contact</a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0 custom_table">
                                    @if ($viewContacts->count() == 0)
                                        <div class="no-data">No Data Available</div>
                                    @else
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                @foreach($columns as $key => $column)
                                                    <th span class="column-name-color">{{$column}} </span> </th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($viewContacts as $contact)
                                                <tr>
                                                    <td>{{ $contact->first_name }}</td>
                                                    <td>{{ $contact->last_name }}</td>
                                                    <td>{{ implode(',',json_decode($contact->mobile_numbers)) }}</td>
                                                    <td>{{ $contact->email }}</td>
                                                    <td>{{ $contact->organization->name }}</td>
                                                    <td>{{ $contact->dob }}</td>
                                                    <td>
                                                        <div class="row icons">
                                                            <div class="col-md-3">
                                                                <a title="View contact" href="{{ route('viewContact',$contact->id) }}"
                                                                   class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <a title="Edit Contact" href="{{ route('editContact',$contact->id) }}"
                                                                   class="btn btn-primary"><i
                                                                        class="fas fa-edit"></i></a>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <form action="{{ route('deleteContact',$contact->id) }}"
                                                                      method="post">
                                                                    {{ csrf_field() }}
                                                                    <button title="Delete Contact" class="btn btn-danger" type="submit"
                                                                            onclick="return confirm('Are you sure you want to delete this Contact?')">
                                                                        <i class="fa fa-trash listdeleteicon"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                @if ($viewContacts->count() == 0)
                                    <div class="no-data"></div>
                                @else
                                    <div class="row pagination">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="dataTables_info">Showing {{ $viewContacts->firstItem() }}
                                                to {{ $viewContacts->lastItem() }} of {{ $viewContacts->total() }}
                                                entries
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            {{$viewContacts->links("pagination::bootstrap-4")}}
                                        </div>
                                    </div>
                                @endif
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- Control Sidebar -->
    </div>
@endsection
