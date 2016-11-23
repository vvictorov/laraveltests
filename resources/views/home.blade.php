@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(session('message'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                 @if(Auth::user()->confirmed == 0) Welcome! Please check your mail to verify your account!

                 @else You are logged in!
                 @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
