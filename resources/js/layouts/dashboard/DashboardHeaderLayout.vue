<script setup lang="ts">
import DashboardContent from '@/components/DashboardContent.vue';
import DashboardHeader from '@/components/DashboardHeader.vue';
import DashboardShell from '@/components/DashboardShell.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <DashboardShell class="flex-col">
        <DashboardHeader :breadcrumbs="breadcrumbs" />
        <DashboardContent>
            <slot />
        </DashboardContent>
    </DashboardShell>
</template>
