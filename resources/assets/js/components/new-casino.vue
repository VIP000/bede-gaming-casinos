<style lang="scss">
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New Casino</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="casinos" @submit="ajax">
                            {{{ csrf_field }}}

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': false,
                                }"
                            >
                                <label class="col-md-4 control-label">Name</label>

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
                                <label class="col-md-4 control-label">Location</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="location" value="">

                                    <span v-if="false" class="help-block">
                                        <strong>{{ errors.location }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="form-group"
                                :class="{
                                    'has-error': false,
                                }"
                            >
                                <label class="col-md-4 control-label">Opening Times</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="opening-times" cols="30" rows="10"></textarea>

                                    <span v-if="false" class="help-block">
                                        <strong>{{ errors.opening-times }}</strong>
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
        </div>
    </div>
</template>

<script>
    export default {
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
            ajax: function() {

            },
        },
    }
</script>
