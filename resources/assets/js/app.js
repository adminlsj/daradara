
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./fileinput.min');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

require('./comment');

$('#avatar-upload').on("change", function(e) {
    $("#avatar-form").submit();
});

$("#orderImgs").fileinput({ 'browseLabel' : '選擇圖片', 'removeLabel' : "刪除圖片" });


