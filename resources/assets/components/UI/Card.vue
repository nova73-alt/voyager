<template>
<div class="card" :class="`border-${border}`">
    <div class="header" v-if="showHeader">
        <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
            <div class="inline-flex items-center" v-if="!$slots.title">
                <icon v-if="icon" :icon="icon" :size="iconSize" class="ltr:mr-2 rtl:ml-2"></icon>
                <component :is="`h${titleSize}`" class="leading-6 font-medium" :class="titlePointer ? 'cursor-pointer' : ''" @click="$emit('click-title', $event)">
                    {{ title }}
                </component>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    {{ description }}
                </p>
            </div>
            <slot v-else name="title" />
            <div class="flex-shrink-0" v-if="$slots.actions">
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
    <div class="content">
        <slot></slot>
    </div>
    <div class="footer" v-if="$slots.footer">
        <slot name="footer"></slot>
    </div>
</div>
</template>
<script>
export default {
    props: {
        showHeader: {
            type: Boolean,
            default: true,
        },
        title: {
            type: String,
            default: '',
        },
        titleSize: {
            type: Number,
            default: 4,
        },
        titlePointer: {
            type: Boolean,
            default: false,
        },
        icon: {
            type: String,
            default: null
        },
        iconSize: {
            type: Number,
            default: 6
        },
        description: {
            type: String,
            default: '',
        },
        border: {
            type: String,
            default: 'default'
        }
    }
};
</script>

<style lang="scss">
@import "../../sass/mixins/bg-color";
@import "../../sass/mixins/border-color";
@import "../../sass/mixins/text-color";

.dark .card {
    @include bg-color(card-bg-color-dark, 'colors.gray.800');
    @include text-color(card-text-color-dark, 'colors.gray.300');

    &.border-default {
        @include border-color(card-border-color-dark, 'colors.gray.700');
    }

    .header {
        @include border-color(card-border-color-dark, 'colors.gray.700');

        h3 {
            @include text-color(card-title-color-dark, 'colors.gray.300');
        }
    }

    .footer {
        @include border-color(card-border-color-dark, 'colors.gray.700');
    }
}

.card {
    @apply shadow border rounded-lg p-4 mb-4 mx-1;
    @include bg-color(card-bg-color, 'colors.white');
    @include text-color(card-text-color, 'colors.gray.700');

    &.border-default {
        @include border-color(card-border-color, 'colors.gray.400');
    }
    .header {
        @apply p-2;
        @include border-color(card-border-color, 'colors.gray.400');

        h3 {
            @include text-color(card-title-color, 'colors.gray.700');
        }
    }

    .content {
        @apply px-2;
    }

    .footer {
        @apply p-2;
        @include border-color(card-border-color-dark, 'colors.gray.700');
    }
}
</style>