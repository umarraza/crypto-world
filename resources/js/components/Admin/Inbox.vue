<template>
    <div>
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <!-- Conversations -->
                    <div class="inbox_chat">
                        <div v-bind:class="{ active_chat: conversation.id == conversation_id, 'chat_list': true }" style="cursor:pointer" v-for="(conversation) in conversations" v-on:click="getConversationMessages(conversation.id)" :key="conversation.id" :id="conversation.id">
                            <div class="chat_people">
                                <div class="chat_img" :id="conversation.id"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <div class="chat_ib" :id="conversation.id">
                                    <h5 :id="conversation.id">{{ conversation.user_name }}<span class="chat_date" :id="conversation.id"></span></h5>
                                    <p :id="conversation.id">{{ conversation.message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mesgs">
                    <div class="msg_history" id="admin_scrolling_div">
                        <div v-for="(message) in messages" :key="message.id">
                            <div class="incoming_msg pt-5" v-if="message.from_user !== data_auth_id">
                                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <input type="hidden" class="conversation_id" :value="message.conversation_id">
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>{{ message.content }}</p>
                                        <span class="time_date"> {{ message.created_at.minutes_ago +' | '+ message.created_at.date }} </span> 
                                    </div>
                                </div>
                            </div>
                            <div class="outgoing_msg" v-else>
                                <div class="sent_msg">
                                    <p>{{ message.content }}</p>
                                    <span class="time_date"> {{ message.created_at.minutes_ago +' | '+ message.created_at.date }} </span> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="type_msg" v-if="isSlected === true">
                        <div class="input_msg_write">
                            <textarea @keyup.enter.exact="onSubmit" class="form-control" v-model="message" placeholder="Type a message" />
                            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
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
                isSlected: false,
                message: '',
                messages:[],
                conversations:[],
                conversation_id: null,
                viewChangeStatus:false,
            }
        },
        mounted() {
            this.getConversations();
        },
        methods: {
            onSubmit() {
                let vm = this;

                axios.post('/admin/message/store',{message: this.message, conversation_id: $('.conversation_id').val()})
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
                $('#admin_scrolling_div').scrollTop($('#admin_scrolling_div')[0].scrollHeight);
            },
            getConversationMessages(id) {
                this.isSlected = true;
                this.conversation_id = id;
                let vm = this;
                axios.post('/admin/user/messages',{id: id})
                .then(function (response) {
                    vm.messages = response.data.messages;
                })
                .catch(function (error) {
                    // 
                });

                // let time_out1 = setTimeout(this.getConversationMessages(this.conversation_id),60000);
            },
            getConversations() {
                let vm = this;

                axios.get('/admin/conversations/')
                .then(function (response) {

                    vm.conversations = [];
                    $.each(response.data.conversations, function (index, conversation) {
                        vm.conversations.push(conversation);
                    });
                })
                .catch(function (error) {
                    // 
                });

                let time_out2 = setTimeout(this.getConversations,60000);
            }
        },
        updated: function (event) {

            this.viewChangeStatus === true ? this.viewChangeStatus = false : this.scrollChat();
        },
    }
</script>
