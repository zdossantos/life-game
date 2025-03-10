<script setup lang="ts">
import type { BreadcrumbItemType } from '@/types';
import Navbar from '@/components/app/Navbar.vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>
<template class="flex flex-col h-screen w-screen">
    <Navbar/>
        <slot />
</template>
