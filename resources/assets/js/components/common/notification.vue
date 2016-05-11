<style lang="scss">
</style>

<template>
    <div
        class="animated alert alert-dismissible"
        :class="notification.type ? 'alert-' + notification.type : 'alert-info'"
        transition="fade"
        role="alert"
    >
        <button
            type="button"
            class="close"
            aria-label="Close"
            @click="triggerClose(notification)"
        >
            <span aria-hidden="true">&times;</span>
        </button>

        <strong v-if="notification.title">{{ notification.title }}</strong>
        <span>{{ notification.text }}</span>
    </div>
</template>

<script>
    export default {
        props: [
            'notification',
        ],
        data: function () {
            return {
                timer: null,
            };
        },
        ready: function () {
            let timeout = this.notification.hasOwnProperty('timeout') ? this.notification.timeout : true;

            if (timeout) {
                let delay = this.notification.delay || 3000;

                this.timer = setTimeout(function () {
                    this.triggerClose(this.notification);
                }.bind(this), delay);
            }
        },

        methods: {
            triggerClose: function (notification) {
                clearTimeout(this.timer);
                this.$dispatch('close-notification', notification);
            },
        },
    };
</script>
