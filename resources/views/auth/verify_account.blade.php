@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verify your account</div>

                    <div class="panel-body">
                        @if(Auth::check())
                            @if(Auth::user()->confirmed == 0)
                                <form class="form-inline" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="verification_code">Confirmation code: </label>
                                        <input type="text" style="margin-left:10px; margin-right:10px;"
                                               class="form-control" name="confirmation_code" id="confirmation_code">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Verify</button>
                                </form>
                                </br>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            @else
                                Your account is verified!
                            @endif
                        @else
                            <form class="form-inline" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="verification_code">Confirmation code: </label>
                                    <input type="text" style="margin-left:10px; margin-right:10px;"
                                           class="form-control" name="confirmation_code" id="confirmation_code">
                                </div>
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </form>
                            </br>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection