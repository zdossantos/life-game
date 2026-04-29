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
<template>
    <div class="flex h-screen w-screen flex-col overflow-hidden bg-background">
        <Navbar />
        <slot />
    </div>
</template>
