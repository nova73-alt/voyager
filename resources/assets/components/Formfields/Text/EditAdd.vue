<template>
    <div>
        <input
            v-if="options.rows == 1"
            type="text"
            class="input w-full"
            v-bind:value="value || translate(options.default_value, true)"
            @input="$emit('input', $event.target.value)"
            :placeholder="translate(options.placeholder, true)">
        <textarea
            v-else
            class="input w-full"
            :rows="options.rows"
            v-bind:value="value || translate(options.default_value)"
            @input="$emit('input', $event.target.value)"
            :placeholder="translate(options.placeholder)"></textarea>
    </div>
</template>

<script>
export default {
    props: ['options', 'value'],
};
</script>