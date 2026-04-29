<script setup lang="ts">
import { DrawerRoot, type DrawerRootEmits, type DrawerRootProps, useForwardPropsEmits } from 'vaul-vue';

const props = defineProps<DrawerRootProps>();
const emits = defineEmits<DrawerRootEmits>();
const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <DrawerRoot v-bind="forwarded">
        <slot />
    </DrawerRoot>
</template>
