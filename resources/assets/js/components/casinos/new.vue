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
                        <form class="form-horizontal" role="form" method="POST" action="casinos" @submit.prevent="ajax">
                            {{{ csrf_field }}}

                            <input type="hidden" name="position_lat">
                            <input type="hidden" name="position_lng">

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': false,
                                }"
                            >
                                <label class="col-md-4 control-label" for="name">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="">

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
                                    <input type="text" class="form-control" name="address" id="address" value="">

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
                                    <textarea class="form-control" name="hours" cols="30" rows="10"></textarea>

                                    <span v-if="false" class="help-block">
                                        <strong>{{ errors.hours }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-btn fa-plus"></i>Add Casino
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-2">
                <map></map>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                csrf_field: null,
            };
        },
        route: {
            data: function(transition) {
                var self = this;

                // get(url, [data], [options])
                return this.$http.get("csrf", {
                    api_token: app.apiToken
                }).then(response => {
                    console.log('fetched csrf token field');

                    return {
                        csrf_field: response.data,
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
                                if (response.ok) {
                                    NotificationStore.addNotification({
                                        type: 'success',
                                        title: response.data.name,
                                        text: 'Your casino has been added!',
                                        timeout: 5000,
                                    });

                                    console.log(JSON.stringify(response.data, null, 4));

                                    self.$router.go({
                                        name: 'casino',
                                        params: {
                                            id: response.data.id,
                                        }
                                    })
                                } else {
                                    form.querySelector('button').removeAttribute('disabled');
                                }
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
