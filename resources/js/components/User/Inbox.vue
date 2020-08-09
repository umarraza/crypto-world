<template>
    <div>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="mesgs user_messages">
                    <div class="msg_history" >
                        <div v-for="(message) in messages" :key="message.id">
                            <div class="incoming_msg" v-if="message.from_user !== data_auth_id">
                                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p>{{ message.content }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="outgoing_msg" v-else>
                                <div class="sent_msg">
                                    <p>{{ message.content }}</p>
                                    <span class="time_date"> 11:01 AM    |    June 9</span> 
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
        props : ['data_messages','data_auth_id'],
        beforeMount: function () {
            let vm = this;
            $.each(this.data_messages, function (index, message) {
                vm.messages.push(message);
            });
        },
        data() {
            return {
                messages:[],
                message: '',
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()

                let vm = this;

                axios.post('/user/messages/store',{message: this.message})
                .then(function (response) {
                    vm.messages = response.data.messages;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        }
    }
</script>
