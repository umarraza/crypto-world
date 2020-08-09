<template>
    <div>
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <!-- Conversations -->
                    <div class="inbox_chat">
                        <div class="chat_list" v-on:click="getConversationMessages" style="cursor:pointer" v-for="(conversation) in conversations" :key="conversation.id" :id="conversation.id">
                            <div class="chat_people">
                                <div class="chat_img" :id="conversation.id"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <div class="chat_ib" :id="conversation.id">
                                    <h5 :id="conversation.id">{{ conversation.user_name }}<span class="chat_date" :id="conversation.id">Dec 25</span></h5>
                                    <p :id="conversation.id">{{ conversation.message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mesgs">
                    <div class="msg_history" >
                        <div v-for="(message) in messages" :key="message.id">
                            <div class="incoming_msg" v-if="message.from_user !== data_auth_id">
                                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <input type="hidden" class="conversation_id" :value="message.conversation_id">
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>{{ message.content }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="outgoing_msg" v-else>
                                <div class="sent_msg">
                                    <p>{{ message.content }}</p>
                                    <span class="time_date"> 11:01 AM | June 9 </span> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="type_msg">
                        <form @submit="onSubmit">
                            <div class="input_msg_write">
                                <input type="text" class="write_msg" v-model="message" placeholder="Type a message" />
                                <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['data_conversations','data_auth_id'],
        beforeMount: function () {
            let vm = this;
            $.each(this.data_conversations, function (index, conversation) {
                vm.conversations.push(conversation);
            });
        },
        data() {
            return {
                message: '',
                messages:[],
                conversations:[],
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()

                let vm = this;

                axios.post('/admin/message/store',{message: this.message, conversation_id: $('.conversation_id').val()})
                .then(function (response) {
                    vm.messages = response.data.messages;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getConversationMessages(e) {

                let vm = this;

                axios.post('/admin/user/messages',{id: e.target.id})
                .then(function (response) {
                    vm.messages = response.data.messages;
                })
                .catch(function (error) {
                    console.log(error);
                });

            }
        },
        computed: {
            // setDateFormat(date) {
            //     const d = new Date(date)
            //     const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d)
            //     const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d)
            //     const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d)

            //     return "`${da}-${mo}-${ye}`";
            // }
        }
    }
</script>
