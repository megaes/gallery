
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

export const event = new Vue();

Vue.component('album-selector', require('./components/album-selector.vue'));
Vue.component('uploader', require('./components/uploader.vue'));
Vue.component('album', require('./components/album.vue'));
Vue.component('paginator', require('./components/paginator.vue'));
Vue.component('modal-window', require('./components/modal-window.vue'));
Vue.component('frame', require('./components/frame.vue'));
Vue.component('gallery', require('./components/gallery.vue'));

const app = new Vue({
    el: '#app'
});

function setDocumentNoscroll(check_aria_expand = null)
{
    let aria_expanded = check_aria_expand ? document.getElementById('app-navbar-collapse').getAttribute('aria-expanded') : null;
    if(!aria_expanded || (aria_expanded == 'false')) {
        let scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop; // Works for Chrome, Firefox, IE...
        document.documentElement.classList.add('noscroll');
        document.documentElement.style.top = -scrollTop + 'px';
    }
}
function unsetDocumentNoscroll(check_aria_expand = null)
{
    let aria_expanded = check_aria_expand ? document.getElementById('app-navbar-collapse').getAttribute('aria-expanded') : null;
    if(!aria_expanded || (aria_expanded == 'false')) {
        document.documentElement.classList.remove('noscroll');
        document.documentElement.scrollTop = document.body.scrollTop = -parseInt(document.documentElement.style.top);
    }
}

$('.dropdown').on("show.bs.dropdown", () => setDocumentNoscroll('true'));
$('.dropdown').on("hidden.bs.dropdown", () => unsetDocumentNoscroll('true'));
$('#app-navbar-collapse').on("show.bs.collapse", () => setDocumentNoscroll());
$('#app-navbar-collapse').on("hidden.bs.collapse", () => unsetDocumentNoscroll());

$('.modal').on("show.bs.modal", function()
{
    let parent = this.parentNode;
    document.getElementById('app').appendChild(this);

    setDocumentNoscroll('true');

    $(this).one("hidden.bs.modal", function()
    {
        unsetDocumentNoscroll('true');
        parent.appendChild(this);
    });
});

