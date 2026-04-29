<script setup lang="ts">
import { DrawerRoot, type DrawerRootEmits, type DrawerRootProps } from 'vaul-vue';

const props = defineProps<DrawerRootProps>();
const emits = defineEmits<DrawerRootEmits>();
</script>

<template>
    <DrawerRoot
        v-bind="props"
        @drag="emits('drag', $event)"
        @release="emits('release', $event)"
        @close="emits('close')"
        @update:open="emits('update:open', $event)"
        @update:activeSnapPoint="emits('update:activeSnapPoint', $event)"
    >
        <slot />
    </DrawerRoot>
</template>
