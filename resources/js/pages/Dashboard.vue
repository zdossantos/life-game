<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const props = defineProps<{
    saves?: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min flex flex-col gap-4 p-4">
                <p v-if="!props.saves || props.saves.length === 0" class="text-muted-foreground text-sm">Aucune sauvegarde trouvée.</p>
                <Link
                    v-for="save in props.saves"
                    :key="save.id"
                    :href="route('home', save.id)"
                    :preserve-scroll="false"
                    as="button"
                    class="flex items-center justify-between rounded-lg border border-sidebar-border/70 dark:border-sidebar-border p-3 hover:bg-accent transition-colors text-left"
                >
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium">Grille {{ save.grid_size }}×{{ save.grid_size }}</span>
                        <span class="text-xs text-muted-foreground">{{ save.cycle_count }} cycle{{ save.cycle_count !== 1 ? 's' : '' }}</span>
                    </div>
                    <span class="text-xs text-muted-foreground">{{ new Date(save.created_at).toLocaleDateString() }}</span>
                </Link>
            </div>
        </div>
    </DashboardLayout>
</template>
