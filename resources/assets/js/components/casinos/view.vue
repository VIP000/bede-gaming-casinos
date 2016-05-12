<style lang="scss">
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ casino.name }}</div>

                    <div class="panel-body">
                        {{{ casino.content }}}
                    </div>
                </div>
            </div>
        </div>

        <div>
            <map :casinos="casinos" :center.sync="center"></map>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                casino: {
                    id: null,
                    name: null,
                    position: {
                        lat: null,
                        lng: null
                    },
                    address: null,
                    hours: null,
                    distance: null,
                    content: null,
                },
                casinos: null,
                center: null,
            };
        },
        route: {
            data: function(transition) {
                var self = this;

                // get(url, [data], [options])
                return this.$http.get('casinos/' + self.$route.params.id)
                    .then(response => {
                        return {
                            casino: response.data,
                            casinos: [
                                response.data,
                            ],
                            center: {
                                lat: Number.parseFloat(response.data.position.lat),
                                lng: Number.parseFloat(response.data.position.lng),
                            },
                        };
                    }, error_response => {
                        console.log('error');
                        console.log(error_response);
                    });
            },
        },
        methods: {
            ajax: function(event) {
                var self = this,
                    form = event.currentTarget,
                    data = new FormData(form),
                    action = form.getAttribute('action');

                form.querySelector('button').setAttribute('disabled', 'disabled');

                return self.$http.post(action, data)
                            .then(response => {
                                // if (response.ok) {
                                    console.log(JSON.stringify(response, null, 4));
                                // } else {
                                //     form.querySelector('button').removeAttribute('disabled');
                                //     NotificationStore.addNotification({
                                //         type: 'error',
                                //         text: 'Invalid Email and/or Password!',
                                //         timeout: false,
                                //     });
                                // }
                            }, error_response => {
                                console.log(JSON.stringify(error_response, null, 4));
                                self.$set('errors', error_response.data);
                                form.querySelector('button').removeAttribute('disabled');
                            });
            },
        },
        components: {
            map: require('../map.vue'),
        },
    }
</script>
