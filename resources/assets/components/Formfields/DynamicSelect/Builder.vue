<template>
    <div>
        <div v-if="show == 'list-options'">
            
        </div>
        <div v-else-if="show == 'view-options'">
            <label class="label mt-4">{{ __('voyager::formfields.dynamic_select.route_name') }}</label>
            <input
                class="input w-full"
                type="text" :placeholder="__('voyager::formfields.dynamic_select.route_name')"
                v-model="options.route_name" />
        </div>
        <div v-else-if="show == 'view'">
            ...
        </div>
    </div>
</template>

<script>
export default {
    props: ['options', 'column', 'show'],
    methods: {
        addOption: function () {
            if (!this.isArray(this.options.options)) {
                this.options.options = [];
            }
            this.options.options.push({
                key: '',
                value: '',
            });
        },
        removeOption: function (key) {
            this.options.options.splice(key, 1);
        }
    }
};
</script>