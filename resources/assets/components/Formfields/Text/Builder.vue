<template>
    <div>
        <div v-if="show == 'list-options'">
            <label for="length" class="label">{{ __('voyager::generic.display_length') }}</label>
            <input type="text" id="length" class="input w-full" v-model="options.display_length"> 
        </div>
        <div v-else-if="show == 'view-options'">
            <label class="label mt-4">{{ __('voyager::generic.placeholder') }}</label>
            <language-input
                class="input w-full"
                type="text" :placeholder="__('voyager::generic.placeholder')"
                v-bind:value="options.placeholder"
                v-on:input="options.placeholder = $event" /> 

            <label class="label mt-4">{{ __('voyager::generic.default_value') }}</label>
            <language-input
                class="input w-full"
                type="text" :placeholder="__('voyager::generic.default_value')"
                v-bind:value="options.default_value"
                v-on:input="options.default_value = $event" /> 

            <label class="label mt-4">{{ __('voyager::generic.rows') }}</label>
            <input type="number" min="1" max="1000" class="input w-full" v-model="options.rows"> 
        </div>
        <div v-else-if="show == 'view'">
            <input
                v-if="options.rows == 1"
                type="text"
                class="input w-full"
                v-bind:value="translate(options.default_value)"
                :placeholder="translate(options.placeholder)">
            <textarea
                v-else
                class="input w-full"
                :rows="options.rows"
                v-bind:value="translate(options.default_value)"
                :placeholder="translate(options.placeholder)"></textarea>
        </div>
    </div>
</template>

<script>
export default {
    props: ['options', 'column', 'show'],
};
</script>