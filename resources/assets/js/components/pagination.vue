<template>
    <div class="pad-top pad-bottom">
        <div class="container text-center">
            <ul class="pagination">
                <li
                    :class="{
                        disabled: prev_url == null
                    }"
                >
                    <span v-if="prev_url == null">&laquo;</span>

                    <a
                        v-else
                        aria-label="Previous"
                        :href="prev_url"
                    >
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li
                    v-for="num in array"
                    track-by="$index"
                    :class="{
                        'active': num == current
                    }"
                >
                    <span v-if="num == current || num == '...'">
                        {{ num }}
                    </span>

                    <a
                        v-if="num != current && num != '...' && $route.query.query"
                        :href="this.base_uri + '?query=' + encodeURIComponent($route.query.query) + '&page=' + num"
                    >{{ num }}</a>

                    <a
                        v-if="num != current && num != '...' && !$route.query.query"
                        :href="this.base_uri + '?page=' + num"
                    >{{ num }}</a>
                </li>

                <li
                    :class="{
                        disabled: next_url == null
                    }"
                >
                    <span v-if="next_url == null">&raquo;</span>

                    <a
                        v-else
                        aria-label="Next"
                        :href="next_url"
                    >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            "to": {
                type: Number,
                default: 1
            },
            "from": {
                type: Number,
                default: 1
            },
            "current": {
                type: Number,
                default: 1
            },
            "last": {
                type: Number,
                default: 1
            },
            "next_url": {
                default: null
            },
            "prev_url": {
                default: null
            },
            offset: {
                type: Number,
                default: 3
            }
        },
        computed: {
            base_uri: function() {
                var self = this,
                    uri;

                if (null !== self.next_url) {
                    uri = self.next_url;
                } else if (null !== self.prev_url) {
                    uri = self.prev_url;
                }

                return uri.replace(/([\w|\/|-]+)[?|\w|=|&]+/g, "$1");
            },
            array: function() {
                var self = this;

                if (!self.to) {
                    return [];
                }

                var from = self.current - self.offset;

                if (from < 1) {
                    from = 1;
                }

                var to = from + (self.offset * 2);

                if (to >= self.last) {
                    to = self.last;
                }

                var arr = [];

                if (from > 4) {
                    arr.push(1);
                    arr.push(2);
                    arr.push('...');
                } else if (from > 3) {
                    arr.push(1);
                    arr.push(2);
                    arr.push(3);
                } else if (from > 2) {
                    arr.push(1);
                    arr.push(2);
                } else if (from > 1) {
                    arr.push(1);
                }

                while (from <= to) {
                    arr.push(from);
                    from++;
                }

                if (to < (self.last - 4)) {
                    arr.push('...');
                    arr.push(self.last - 1);
                    arr.push(self.last);
                } else if (to < (self.last - 3)) {
                    arr.push(self.last - 2);
                    arr.push(self.last - 1);
                    arr.push(self.last);
                } else if (to < (self.last - 2)) {
                    arr.push(self.last - 1);
                    arr.push(self.last);
                } else if (to < (self.last - 1)) {
                    arr.push(self.last);
                }

                return arr;
            }
        }
    }
</script>
