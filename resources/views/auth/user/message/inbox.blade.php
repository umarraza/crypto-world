@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<!-- begin:: Content -->

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="container">
        <example-component></example-component>
        {{-- <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
            <div class="mesgs user_messages">
                <div class="msg_history">
                    
                    @foreach ($adminMessages as $message)
                        <div class="incoming_msg mt-5">
                            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                    <p>{{ $message->content }}</p>
                                    <span class="time_date"> {{ $message->created_at->toFormattedDateString() }}    |    {{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    
                    @foreach ($userMessages as $message)
                        <div class="outgoing_msg">
                            <div class="sent_msg">
                                <p>{{ $message->content }}</p>
                                <span class="time_date"> {{ $message->created_at->toFormattedDateString() }}    |    {{ $message->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach


                </div>
                <div class="type_msg">
                    {{ Form::open(array('route' => 'user.messages.store','class' => 'kt-form')) }}
                        <div class="input_msg_write">
                            {!! Form::text('message', null, ['class' => 'write_msg', 'placeholder' => 'Type a message']) !!}
                            <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        </div> --}}
    </div>
</div>
<!-- end:: Content -->
@endsection