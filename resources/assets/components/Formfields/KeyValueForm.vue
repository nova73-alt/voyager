<template>
    <div>
        <div class="w-full flex">
            <div class="w-4/6">
                <h5>{{ __('voyager::generic.options') }}</h5>
            </div>
            <div class="w-2/6 text-right">
                <button class="button green small icon-only" @click.stop="addOption">
                    <icon icon="plus" />
                </button>
            </div>
        </div>
        <div class="voyager-table">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('voyager::generic.key') }}</th>
                        <th>{{ __('voyager::generic.value') }}</th>
                        <th>{{ __('voyager::generic.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(option, i) in dynamicOptions" :key="'option-'+i">
                        <td>
                            <input type="text" class="input w-full" v-model="option.key" :placeholder="__('voyager::generic.key')">
                        </td>
                        <td>
                            <language-input
                                class="input w-full"
                                type="text"
                                :placeholder="__('voyager::generic.value')"
                                v-bind:value="option.value"
                                v-on:input="option.value = $event" />
                        </td>
                        <td>
                            <button class="button red small icon-only" @click.stop="removeOption(i)">
                                <icon icon="trash" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        value: {
            type: Array,
            required: true,
        }
    },
    data: function () {
        return {
            dynamicOptions: this.value,
        };
    },
    methods: {
        addOption: function () {
            if (!this.isArray(this.dynamicOptions)) {
                this.dynamicOptions = [];
            }
            this.dynamicOptions.push({
                key: '',
                value: '',
            });
        },
        removeOption: function (key) {
            this.dynamicOptions.splice(key, 1);
        }
    },
    watch: {
        dynamicOptions: function (options) {
            this.$emit('input', options);
        }
    }
}
</script>