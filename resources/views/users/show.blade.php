@extends('layout')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-lg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="card-header pb-0">
                                    <h2>Show User</h2>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Email:</strong>
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Roles:</strong>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $v)
                                                    <label class="badge bg-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('argon/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/smooth-scrollbar.min.js') }}"></script>
@endsection


