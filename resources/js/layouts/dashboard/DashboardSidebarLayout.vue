<script setup lang="ts">
import DashboardContent from '@/components/dashboard/DashboardContent.vue';
import DashboardShell from '@/components/dashboard/DashboardShell.vue';
import DashboardSidebar from '@/components/dashboard/DashboardSidebar.vue';
import DashboardSidebarHeader from '@/components/dashboard/DashboardSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <DashboardShell variant="sidebar">
        <DashboardSidebar />
        <DashboardContent variant="sidebar">
            <DashboardSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </DashboardContent>
    </DashboardShell>
</template>
