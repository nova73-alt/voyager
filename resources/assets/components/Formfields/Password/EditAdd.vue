<template>
    <div>
        <input
            type="password"
            class="input w-full"
            @input="$emit('input', $event.target.value)"
            :placeholder="translate(options.placeholder, true)">
    </div>
</template>

<script>
export default {
    props: ['options', 'value'],
};
</script>