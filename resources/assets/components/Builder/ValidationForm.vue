<template>
    <div class="mt-5">
        <div class="w-full flex">
            <div class="w-4/6">
                <h5>{{ __('voyager::generic.validation') }}</h5>
            </div>
            <div class="w-2/6 text-right">
                <button class="button green small icon-only" @click.stop="addRule">
                    <icon icon="plus" />
                </button>
            </div>
        </div>
        <div class="voyager-table">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('voyager::generic.rule') }}</th>
                        <th>{{ __('voyager::generic.message') }}</th>
                        <th>{{ __('voyager::generic.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(rule, key) in reactiveRules" :key="'rule-'+key">
                        <td>
                            <input type="text" class="input w-full" v-model="rule.rule" :placeholder="__('voyager::generic.rule')">
                        </td>
                        <td>
                            <language-input
                                class="input w-full"
                                type="text" :placeholder="__('voyager::generic.message')"
                                v-bind:value="rule.message"
                                v-on:input="rule.message = $event" />
                        </td>
                        <td>
                            <button class="button red small icon-only" @click.stop="removeRule(key)">
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
    props: ['value'],
    data: function () {
        return {
            reactiveRules: this.value,
        };
    },
    methods: {
        addRule: function () {
            if (!this.isArray(this.reactiveRules)) {
                this.reactiveRules = [];
            }
            this.reactiveRules.push({
                rule: '',
                message: '',
            });
        },
        removeRule: function (key) {
            this.reactiveRules.splice(key, 1);
        }
    },
    watch: {
        reactiveRules: function (rules) {
            this.$emit('input', rules);
        }
    },
};
</script>