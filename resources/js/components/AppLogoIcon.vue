<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img
        src="/icon-32.png"
        srcset="/icon-16.png 16w, /icon-32.png 32w, /icon-180.png 180w, /icon-512.png 512w"
        sizes="40px"
        alt="Life Game logo"
        :class="className"
        v-bind="$attrs"
    />
</template>
