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

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('loyalty', require('./components/Loyalty.vue').default);
Vue.component('coupons-component', require('./components/Coupons.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('my-coupons-component', require('./components/MyCouponsComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('forgot-pin-component', require('./components/ForgotPinComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Notify = function(text, callback, close_callback, style) {

    var time = '10000';
    var $container = $('#notifications');
    var icon = '<i class="fa fa-info-circle "></i>';

    if (typeof style === 'undefined' ) style = 'warning';

    var html = $('<div class="alert alert-' + style + '  hide">' + icon +  " " + text + '</div>');

    $('<a>',{
        text: '×',
        class: 'button close',
        style: 'padding-left: 10px;',
        href: '#',
        click: function(e){
            e.preventDefault();
            close_callback && close_callback();
            remove_notice();
        }
    }).prependTo(html);

    $container.prepend(html);
    html.removeClass('hide').hide().fadeIn('slow');

    function remove_notice() {
        html.stop().fadeOut('slow').remove();
    }

    var timer =  setInterval(remove_notice, time);

    $(html).hover(function(){
        clearInterval(timer);
    }, function(){
        timer = setInterval(remove_notice, time);
    });

    html.on('click', function () {
        clearInterval(timer);
        callback && callback();
        remove_notice();
    });

};

const app = new Vue({
    el: '#app',
    methods: {

    }
});