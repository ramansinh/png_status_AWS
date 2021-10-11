@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    {{--<div class="col-sm-6 text-right">--}}
                    {{--<ol class="breadcrumb float-sm-right">--}}
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    {{--<li class="breadcrumb-item active">DataTables</li>--}}
                    {{--</ol>--}}
                    {{--</div>--}}
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body  p-0">
                            <table class="table table-bordered">
                                <thead>
                                {{--<tr>--}}
                                    {{--<th width="30%">Image</th>--}}
                                    {{--<td width="70%">{{ $record['image'] }}</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <th width="30%">Category Name</th>
                                    <td width="70%">{{ $record['category']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th >Language</th>
                                    <td >{{ $record['language'] }}</td>
                                </tr>
                                <tr>
                                    <th >Preview Image</th>
                                    <td ><img src="{{ $record['preview_image_url'] }}" width="250"></td>
                                </tr>
                                <tr>
                                    <th >Frame Image</th>
                                    <td ><img src="{{ $record['frame_image_url'] }}" width="250"></td>
                                </tr>

                                <tr>
                                    <th width="30%">Created At</th>
                                    <td width="70%">{{ $record['created_at']->format('d-m-Y H:i:s') }} </td>
                                </tr>
                                <tr>
                                    <th width="30%">Status</th>
                                    <td width="70%">{{ $record['status'] }}</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route($route.'index') }}" type="submit" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

