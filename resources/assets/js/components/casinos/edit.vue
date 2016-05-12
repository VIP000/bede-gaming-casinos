<style lang="scss">
    #map {
        height: calc(100vh - 200px);
    }
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New Casino</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="casinos/{{ casino.id }}" @submit.prevent="ajaxUpdate">
                            <input type="hidden" name="position_lat" :value="casino.position_lat">
                            <input type="hidden" name="position_lng" :value="casino.position_lng">

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': false,
                                }"
                            >
                                <label class="col-md-4 control-label" for="name">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" :value="casino.name">

                                    <span v-if="false" class="help-block">
                                        <strong>{{ errors.name }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': false,
                                }"
                            >
                                <label class="col-md-4 control-label" for="address">Address</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" id="address" :value="casino.address">

                                    <span v-if="false" class="help-block">
                                        <strong>{{ errors.address }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': false,
                                }"
                            >
                                <label class="col-md-4 control-label" for="hours">Opening Times</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="hours" cols="30" rows="10">{{{ casino.hours }}}</textarea>

                                    <span v-if="false" class="help-block">
                                        <strong>{{ errors.hours }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-btn fa-check"></i>Update Casino
                                    </button>

                                    <button type="delete" class="btn btn-danger pull-left" @click.prevent="ajaxDelete">
                                        <i class="fa fa-btn fa-trash-o"></i>Delete Casino
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-2">
                <map :casinos="casinos" :center.sync="center"></map>
            </div>
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
            ajaxUpdate: function(event) {
                var self = this,
                    form = document.querySelector('form'),
                    data = new FormData(form),
                    action = form.getAttribute('action');

                form.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled');
                form.querySelector('button[type="delete"]').setAttribute('disabled', 'disabled');

                return self.$http.put(action, data)
                            .then(response => {
                                NotificationStore.addNotification({
                                    type: 'success',
                                    text: 'Casino Updated!',
                                });

                                self.$router.go({
                                    name: 'casino',
                                    params: {
                                        id: self.casino.id,
                                    }
                                })
                            }, error_response => {
                                console.log(JSON.stringify(error_response, null, 4));
                                self.$set('errors', error_response.data);

                                form.querySelector('button[type="submit"]').removeAttribute('disabled');
                                form.querySelector('button[type="delete"]').removeAttribute('disabled');
                            });
            },
            ajaxDelete: function(event) {
                var self = this,
                    form = document.querySelector('form'),
                    data = new FormData(form),
                    action = form.getAttribute('action');

                form.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled');
                form.querySelector('button[type="delete"]').setAttribute('disabled', 'disabled');

                return self.$http.delete(action)
                            .then(response => {
                                NotificationStore.addNotification({
                                    type: 'success',
                                    text: 'Casino Deleted!',
                                });

                                self.$router.go({
                                    name: 'home',
                                })
                            }, error_response => {
                                console.log(JSON.stringify(error_response, null, 4));
                                self.$set('errors', error_response.data);

                                form.querySelector('button[type="submit"]').removeAttribute('disabled');
                                form.querySelector('button[type="delete"]').removeAttribute('disabled');
                            });
            },
        },
        components: {
            map: require('../map.vue'),
        },
    }
</script>
