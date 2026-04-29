<script setup lang="ts">
import { DrawerTrigger } from 'vaul-vue';
</script>

<template>
    <DrawerTrigger v-bind="$attrs">
        <slot />
    </DrawerTrigger>
</template>
