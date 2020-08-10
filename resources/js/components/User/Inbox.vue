<template>
    <div>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="mesgs user_messages">
                    <div class="msg_history" id="scrolling_div">
                        <div v-for="(message) in messages" :key="message.id">
                            <div class="incoming_msg pt-5" v-if="message.from_user !== data_auth_id">
                                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>{{ message.content }}</p>
                                        <span class="time_date"> {{ message.created_at.minutes_ago +' | '+ message.created_at.date }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="outgoing_msg" v-else>
                                <div class="sent_msg">
                                    <p>{{ message.content }}</p>
                                    <span class="time_date"> {{ message.created_at.minutes_ago +' | '+ message.created_at.date }}</span> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <textarea @keyup.enter.exact="onSubmit" class="form-control" v-model="message" placeholder="Type a message" />
                            <button class="msg_send_btn" type="button" @click="onSubmit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['data_auth_id'],
        beforeMount: function () {
            // 
        },
        data() {
            return {
                messages:[],
                message: '',
                viewChangeStatus:false,
            }
        },
        created: function(){
            this.getUserMessages();
        },
        methods: {
            onSubmit() {
                let vm = this;

                axios.post('/user/messages/store',{message: this.message})
                .then(function (response) {
                    vm.messages = response.data.messages;
                })
                .catch(function (error) {
                    // 
                });

                vm.message = '';
            },
            scrollChat()
            {
                $('#scrolling_div').scrollTop($('#scrolling_div')[0].scrollHeight);
            },
            getUserMessages() {

                let vm = this;

                axios.get('/user/messages/all')
                .then(function (response) {

                    vm.messages = [];
                    $.each(response.data.messages, function (index, message) {
                        vm.messages.push(message);
                    });
                })
                .catch(function (error) {
                    // 
                });

                setTimeout(this.getUserMessages,60000);
            }
        },
        updated: function (event) {

            this.viewChangeStatus === true ? this.viewChangeStatus = false : this.scrollChat();
        },
    }
</script>
