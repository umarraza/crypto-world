@extends('layouts.app')

@section('title', __('Withdraw verification | Crypto World'))

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="container">
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
              <div class="inbox_msg">
                <div class="inbox_people">
                  <div class="headind_srch">
                    <div class="recent_heading">
                      <h4>Recent</h4>
                    </div>
                    <div class="srch_bar">
                      <div class="stylish-input-group">
                        <input type="text" class="search-bar"  placeholder="Search" >
                        <span class="input-group-addon">
                        <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                        </span> </div>
                    </div>
                  </div>
                  <div class="inbox_chat">
                    @foreach ($conversations as $conversation)
                        <a href="{{ route('admin.getMessages', ['user_id'=>$conversation->user->id]) }}">
                            <div class="chat_list">
                                <div class="chat_people">
                                    <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                    <div class="chat_ib">
                                        <h5>{{ $conversation->user->full_name }} <span class="chat_date">{{ $conversation->user->messages->first()->created_at->toFormattedDateString() }}</span></h5>
                                        <p>{{ $conversation->user->messages->first()->content }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                  </div>
                </div>
                <div class="mesgs">
                    <div class="msg_history">
                        {{-- @foreach ($userMessages as $message)
                            <div class="incoming_msg mt-5">
                                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>{{ $message->content }}</p>
                                        <span class="time_date"> {{ $message->created_at->toFormattedDateString() }}    |    {{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}
                    
                        @foreach ($adminMessages as $message)
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p>{{ $message->content }}</p>
                                    <span class="time_date"> {{ $message->created_at->toFormattedDateString() }}    |    {{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input type="text" class="write_msg" placeholder="Type a message" />
                            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
              </div>
              
            </div></div>
</div>
@endsection