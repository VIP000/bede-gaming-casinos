export default {
    state: [], // here the notifications will be added

    addNotification: function (notification) {
        this.state.push(notification)
    },

    removeNotification: function (notification) {
        this.state.$remove(notification)
    },
}
