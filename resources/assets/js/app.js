require('bootstrap-without-jquery');
require('./number-format.js');

let Vue = require('vue');
let VueRouter = require('vue-router');

Vue.use(VueRouter);
Vue.use(require('vue-resource'));

Vue.http.options.root = '/api';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');

var fourOhfour = Vue.extend({
    // You can use also use template path (Thanks to @jcerdan)
    // path : '/path/to/component.html'
    template: '<h1>[404] Not Found</h1>'
});

var router = new VueRouter({
    hashbang: false,
    history: true,
    transitionOnLoad: true,
    saveScrollPosition: true,
    linkActiveClass: 'active'
});

var authRedirect = Vue.extend({
    ready: function() {
        console.log('login required');

        window.location = window.location.protocol + '//' + window.location.hostname + '/login';
    }
});

router.beforeEach(function (transition) {
    if (transition.to.authOnly) {
        if (!app.userId && !app.apiToken) {
            transition.redirect('/auth');
        }
    }

    return true;
});

router.map({
    '*': {
        component: fourOhfour
    },
    '/': {
        name: 'home',
        component: require('./components/home.vue'),
    },
    '/auth': {
        name: 'auth',
        component: authRedirect,
    },
    '/search': {
        name: 'search',
        component: require('./components/search.vue'),
    },
    '/new-casino': {
        name: 'new-casino',
        component: require('./components/new-casino.vue'),
        authOnly: true,
    },
});

router.start(Vue.extend({}), 'html')
