<script setup lang="ts">
import { cn } from '@/lib/utils';
import { DrawerDescription } from 'vaul-vue';
import { type HTMLAttributes } from 'vue';

const props = defineProps<{ class?: HTMLAttributes['class'] }>();
</script>

<template>
    <DrawerDescription :class="cn('text-sm text-muted-foreground', props.class)">
        <slot />
    </DrawerDescription>
</template>
