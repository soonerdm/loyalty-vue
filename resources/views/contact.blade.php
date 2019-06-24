@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-sm-center mt-4">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-envelope"></i> Contact Us
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ action('ContactController@store') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" id="name" name="name" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" id="email" name="email" />
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" rows="3" id="message" name="message"></textarea>
                                </div>
                                <div class="col-md-12 text-right">
                                    <a href="/" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

