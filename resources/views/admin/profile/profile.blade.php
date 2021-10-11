@extends('admin.layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }} </h1>
                    </div>
                    <div class="col-sm-6 text-right">
{{--                        <a href="{{ route($route.'create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> Add new</a>--}}

                        {{--<ol class="breadcrumb float-sm-right">--}}
                            {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                            {{--<li class="breadcrumb-item active">DataTables</li>--}}
                        {{--</ol>--}}

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    @include('admin.flash')
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Form Field</h3>
                        </div>

                        {!! Form::model($record, ['route' => ['admin.profile_store'],'files' =>true , 'id'=>'myform', 'method' => 'post', 'class' => 'ajax_submit']) !!}
                        <div class="card-body">
                            <div class="message-section">
                                @include('admin.message_section')
                            </div>
{{--                            @include('admin.category.form')--}}
                            @component('admin.component.text', [
                               'name' => 'name',
                               'title' => 'Name',
                               'value'=>null,
                               'required'=>true,
                               'options'=>['placeholder'=>'Enter name']
                            ])@endcomponent
                            @component('admin.component.text', [
                               'name' => 'email',
                               'title' => 'Email',
                               'value'=>null,
                               'required'=>true,
                               'options'=>['placeholder'=>'Enter email']
                            ])@endcomponent
                            @component('admin.component.password', [
                               'name' => 'password',
                               'title' => 'Password',
                               'value'=>null,
                               'required'=>false,
                               'options'=>['placeholder'=>'Enter password','autocomplete'=>'off']
                            ])@endcomponent



                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
{{--                            <a href="{{ route($route.'index') }}" type="submit" class="btn btn-default">Back</a>--}}
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

    </div>
@endsection

@section('js')
    {{--<script>--}}
        {{--$(function () {--}}
            {{--$("#example1").DataTable();--}}
        {{--});--}}
    {{--</script>--}}
    <!-- DataTables -->
@endsection