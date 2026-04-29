<script setup lang="ts">
import { computed } from 'vue';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { CalendarDays, Gamepad2, Grid2X2, Plus, RefreshCw } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';

const { t, locale } = useI18n();

const page = usePage<SharedData>();
const user = page.props.auth.user;

const props = defineProps<{
    saves?: {
        id: number;
        grid_size: number;
        cycle_count: number;
        created_at: string;
    }[];
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
]);

const totalSaves = computed(() => props.saves?.length ?? 0);
const totalCycles = computed(() => props.saves?.reduce((sum, s) => sum + s.cycle_count, 0) ?? 0);
const uniqueGridSizes = computed(() => new Set(props.saves?.map((s) => s.grid_size) ?? []).size);

const formatDate = (dateStr: string) =>
    new Date(dateStr).toLocaleDateString(locale.value === 'fr' ? 'fr-FR' : 'en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
</script>

<template>
    <Head :title="t('dashboard.title')" />

    <DashboardLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
            <!-- Welcome header -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">{{ t('dashboard.greeting', { name: user.name }) }}</h2>
                    <p class="mt-1 text-sm text-muted-foreground">{{ t('dashboard.subtitle') }}</p>
                </div>
                <Link
                    :href="route('home')"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" />
                    {{ t('dashboard.newGame') }}
                </Link>
            </div>

            <!-- Stats cards -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium text-muted-foreground">{{ t('dashboard.savedGames') }}</CardTitle>
                        <Gamepad2 class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">{{ totalSaves }}</p>
                        <p class="mt-1 text-xs text-muted-foreground">{{ t('dashboard.savedGamesDesc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium text-muted-foreground">{{ t('dashboard.totalCycles') }}</CardTitle>
                        <RefreshCw class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">{{ totalCycles.toLocaleString(locale) }}</p>
                        <p class="mt-1 text-xs text-muted-foreground">{{ t('dashboard.totalCyclesDesc') }}</p>
                    </CardContent>
                </Card>

                <Card class="sm:col-span-2 lg:col-span-1">
                    <CardHeader class="flex flex-row items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium text-muted-foreground">{{ t('dashboard.gridSizes') }}</CardTitle>
                        <Grid2X2 class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">{{ uniqueGridSizes }}</p>
                        <p class="mt-1 text-xs text-muted-foreground">{{ t('dashboard.gridSizesDesc') }}</p>
                    </CardContent>
                </Card>
            </div>

            <!-- Saves list -->
            <Card class="flex-1">
                <CardHeader>
                    <CardTitle class="text-base">{{ t('dashboard.latestSims') }}</CardTitle>
                </CardHeader>
                <CardContent class="p-0">
                    <!-- Empty state -->
                    <div v-if="!props.saves || props.saves.length === 0" class="flex flex-col items-center gap-3 px-6 py-12 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-muted">
                            <Gamepad2 class="h-6 w-6 text-muted-foreground" />
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ t('dashboard.emptyTitle') }}</p>
                            <p class="mt-1 text-xs text-muted-foreground">{{ t('dashboard.emptyDesc') }}</p>
                        </div>
                        <Link
                            :href="route('home')"
                            class="mt-1 inline-flex items-center gap-1.5 rounded-md bg-primary px-3 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            <Plus class="h-3 w-3" />
                            {{ t('dashboard.start') }}
                        </Link>
                    </div>

                    <!-- Save rows -->
                    <template v-else>
                        <Link
                            v-for="save in props.saves"
                            :key="save.id"
                            :href="route('home', save.id)"
                            :preserve-scroll="false"
                            as="button"
                            class="flex w-full items-center gap-4 border-b border-border/60 px-6 py-3.5 text-left transition-colors last:border-0 hover:bg-accent/50"
                        >
                            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-muted">
                                <Grid2X2 class="h-4 w-4 text-muted-foreground" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium">{{ t('dashboard.grid', { size: save.grid_size }) }}</p>
                                <p class="mt-0.5 text-xs text-muted-foreground">
                                    {{ t('dashboard.cycles', save.cycle_count, { count: save.cycle_count }) }}
                                </p>
                            </div>
                            <div class="flex flex-shrink-0 items-center gap-1.5 text-xs text-muted-foreground">
                                <CalendarDays class="h-3.5 w-3.5" />
                                {{ formatDate(save.created_at) }}
                            </div>
                        </Link>
                    </template>
                </CardContent>
            </Card>
        </div>
    </DashboardLayout>
</template>
