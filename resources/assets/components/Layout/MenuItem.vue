<template>
<div class="menuitem">
    <div class="item" :class="[active ? 'active' : '']">
        <div class="inline-flex items-center">
            <a :href="href" class="text-sm leading-5 link" @click="clickItem">
                <icon :icon="icon" class="icon ltr:mr-2 rtl:ml-2" :size="6"></icon>
                {{ title }}
            </a>
        </div>
        <div class="flex-shrink-0 cursor-pointer inline-flex items-center" @click="open = !open">
            <icon :icon="open ? 'chevron-up' : 'chevron-down'" v-if="$slots.default" :size="4" class="icon"></icon>
        </div>
    </div>
    
    <collapse-transition v-if="$slots.default" :class="[open ? 'submenu' : '']" :duration="200">
        <slot v-if="open" />
    </collapse-transition>
</div>
</template>

<script>
export default {
    props: {
        icon: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        href: {
            type: String,
            required: false,
            default: '#'
        },
        active: {
            type: Boolean,
            default: false,
        },
        isOpen: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            open: this.isOpen,
        }
    },
    methods: {
        clickItem: function (e) {
            if (this.href == '' || this.href == '#') {
                e.preventDefault();
                this.open = !this.open;
            }
        }
    },
    created: function () {
        if (this.active) {
            this.open = true;
        }
    }
};
</script>

<style lang="scss" scoped>
.menuitem {
    .item {
        @apply flex items-center justify-between flex-wrap rounded-md font-medium mt-1 px-2 py-2;

        .link {
            @apply flex items-center flex-wrap;
        }
    }

    .submenu {
        @apply rounded-md ml-2;
    }
}
</style>