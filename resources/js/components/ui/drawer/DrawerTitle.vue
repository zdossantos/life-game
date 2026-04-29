<script setup lang="ts">
import { cn } from '@/lib/utils';
import { DrawerTitle } from 'vaul-vue';
import { type HTMLAttributes } from 'vue';

const props = defineProps<{ class?: HTMLAttributes['class'] }>();
</script>

<template>
    <DrawerTitle :class="cn('text-lg font-semibold leading-none tracking-tight', props.class)">
        <slot />
    </DrawerTitle>
</template>
