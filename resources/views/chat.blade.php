@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
                 <div class="card">
                <div class="card-header">{{'Messages'}}</div>

                <div class="card-body">
                    <chat-messages  :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                <input type="hidden" value="{{ Auth::user()->id }}" id="user_id">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                    ></chat-form>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection