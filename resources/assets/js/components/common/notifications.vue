<style lang="scss">
    .notifications {
        position: fixed;
        right: 10px;
        top: 10px;
        width: 350px;
        z-index: 999999;
    }
</style>

<template>
    <div class="notifications">
        <notification
            v-for="notification in notifications"
            :notification="notification"
            @close-notification="removeNotification"
            transition="fade"
        ></notification>
    </div>
</template>

<script>
    export default {
        components: {
            notification: require('./notification.vue'),
        },
        data () {
            return {
                notifications: NotificationStore.state,
            };
        },
        methods: {
            removeNotification: function (notification) {
                NotificationStore.removeNotification(notification);
            },
        },
    };
</script>
