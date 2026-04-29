<script setup lang="ts">
import { cn } from '@/lib/utils';
import { DrawerOverlay } from 'vaul-vue';
import { type HTMLAttributes } from 'vue';

const props = defineProps<{ class?: HTMLAttributes['class'] }>();
</script>

<template>
    <DrawerOverlay :class="cn('fixed inset-0 z-50 bg-black/80', props.class)" />
</template>
