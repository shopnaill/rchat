
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


import ChatMessages from './components/ChatMessages.vue';
Vue.component('chat-messages', ChatMessages);

import ChatForm from './components/ChatForm.vue';
Vue.component('chat-form', ChatForm);
var muid = 0;
const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        user:document.getElementById('user_id').value
    },

    created() {
        this.fetchMessages();
        var channel = Echo.private(`chats.messages.${this.user}`);
        channel
            .listen('.my-event', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
             
            });
    },

    methods: {
        fetchMessages()
        {
            axios.get('/messages/'+ _.last( window.location.pathname.split( '/' ) )).then(res => (this.messages = res.data)) 
        }
        ,
        addMessage(message) {
           this.messages.push(message);
            axios.post('/messages/send', message).then(response => {});
        }
    }
});