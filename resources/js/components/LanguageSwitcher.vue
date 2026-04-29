<script setup lang="ts">
import { setLocale, type SupportedLocale } from '@/i18n';
import { useI18n } from 'vue-i18n';

interface Props {
    class?: string;
}

defineProps<Props>();

const { t, locale } = useI18n();

const flags: Record<SupportedLocale, string> = {
    en: '🇬🇧',
    fr: '🇫🇷',
};

function toggle() {
    const next: SupportedLocale = locale.value === 'fr' ? 'en' : 'fr';
    setLocale(next);
}
</script>

<template>
    <button
        type="button"
        :title="t('language.label')"
        :aria-label="t('language.label')"
        :class="['inline-flex items-center gap-1.5 rounded-md px-2 py-1.5 text-sm transition-colors hover:bg-accent hover:text-accent-foreground', $props.class]"
        @click="toggle"
    >
        <span class="text-base leading-none">{{ flags[locale as SupportedLocale] }}</span>
        <span class="text-xs font-medium uppercase tracking-wide">{{ locale }}</span>
    </button>
</template>
