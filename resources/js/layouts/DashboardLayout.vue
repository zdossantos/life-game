<script setup lang="ts">
import DashboardSidebarLayout from '@/layouts/dashboard/DashboardSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <DashboardSidebarLayout :breadcrumbs="breadcrumbs">
        <slot />
    </DashboardSidebarLayout>
</template>
