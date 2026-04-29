<script setup lang="ts">
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import AppearanceTabs from '@/components/dashboard/AppearanceTabs.vue';
import HeadingSmall from '@/components/dashboard/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import SettingsLayout from '@/layouts/settings/Layout.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const { t } = useI18n();

const breadcrumbItems = computed<BreadcrumbItem[]>(() => [
    {
        title: t('appearance.pageTitle'),
        href: '/settings/appearance',
    },
]);
</script>

<template>
    <DashboardLayout :breadcrumbs="breadcrumbItems">
        <Head :title="t('appearance.pageTitle')" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall :title="t('appearance.sectionTitle')" :description="t('appearance.sectionDesc')" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </DashboardLayout>
</template>
