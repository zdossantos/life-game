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
        src="/icon-512.png"
        srcset="/icon-16.png 16w, /icon-32.png 32w, /icon-180.png 180w, /icon-512.png 512w"
        sizes="(max-width: 32px) 16px, (max-width: 180px) 32px, 512px"
        alt="Life Game logo"
        :class="className"
        v-bind="$attrs"
    />
</template>
