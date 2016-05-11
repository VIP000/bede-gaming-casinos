<style lang="scss">
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/register" @submit.prevent="ajax">
                            {{{ csrf_field }}}

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': undefined !== errors.name,
                                }"
                            >
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name">

                                    <span v-if="undefined != errors.name" class="help-block">
                                        <strong>{{ errors.name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': undefined !== errors.email,
                                }"
                            >
                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="email">

                                    <span v-if="undefined != errors.email" class="help-block">
                                        <strong>{{ errors.email[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': undefined !== errors.password,
                                }"
                            >
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    <span v-if="undefined != errors.password" class="help-block">
                                        <strong>{{ errors.password[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': undefined !== errors.password || undefined !== errors.password_confirmation,
                                }"
                            >
                                <label class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">

                                    <span v-if="undefined != errors.password_confirmation" class="help-block">
                                        <strong>{{ errors.password_confirmation[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                csrf_field: null,
                errors: {},
            };
        },
        route: {
            data: function(transition) {
                var self = this;

                if (app.userId != false && app.apiToken != null) {
                    self.$route.router.go({
                        name: 'home',
                    });
                }

                // get(url, [data], [options])
                return this.$http.get("csrf", {
                    api_token: app.apiToken
                }).then(response => {
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
                                self.getUserInformation();
                            }, error_response => {
                                self.$set('errors', error_response.data);
                                form.querySelector('button').removeAttribute('disabled');
                            });
            },
            getUserInformation: function() {
                var self = this

                return this.$http.get("profile").then(response => {
                    app.userId = response.data.id;
                    app.name = response.data.name;
                    app.apiToken = response.data.api_token;
                    app.isAdmin = response.data.is_admin;

                    location.reload();
                });
            },
        },
    }
</script>
