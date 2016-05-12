require('bootstrap-without-jquery');
require('./number-format.js');
require('./merge_options.js');

let Vue = require('vue');
let VueRouter = require('vue-router');

Vue.use(VueRouter);
Vue.use(require('vue-resource'));

Vue.http.options.root = '/api';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');

Vue.transition('fade', {
    enterClass: 'fadeInDown', // class of animate.css
    leaveClass: 'fadeOutDown' // class of animate.css
})

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

router.beforeEach(function (transition) {
    if (transition.to.guestOnly) {
        if (app.userId !== false && app.apiToken !== null) {
            transition.redirect('/');
        }
    }

    if (transition.to.authOnly) {
        if (!app.userId && !app.apiToken) {
            transition.redirect('/login');
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
    '/login': {
        name: 'login',
        component: require('./components/auth/login.vue'),
        guestOnly: true,
    },
    '/register': {
        name: 'register',
        component: require('./components/auth/register.vue'),
        guestOnly: true,
    },
    // '/search': {
    //     name: 'search',
    //     component: require('./components/search.vue'),
    // },
    '/new-casino': {
        name: 'new-casino',
        component: require('./components/casinos/new.vue'),
        authOnly: true,
    },
    '/:id': {
        name: 'casino',
        component: require('./components/casinos/view.vue'),
    },
    '/:id/edit': {
        name: 'edit-casino',
        component: require('./components/casinos/edit.vue'),
        authOnly: true,
    },
});

router.start(Vue.extend({
    data: function() {
        return {
            user: {
                userId: app.userId,
                name: app.name,
                apiToken: app.apiToken,
                isAdmin: app.isAdmin,
            },
        };
    },
    components: {
        notification: require('./components/common/notification.vue'),
        notifications: require('./components/common/notifications.vue'),
    },
    ready: function() {
        if (this.user.userId !== false && this.user.apiToken !== null) {
            NotificationStore.addNotification({
                type: 'success',
                text: 'Hey there ' + this.user.name + '!',
                timeout: true,
                delay: 5000,
            });
        }
    },
    NotificationStore: NotificationStore,
}), 'html')
