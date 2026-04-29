<script setup lang="ts">
import { setLocale, SUPPORTED_LOCALES, type SupportedLocale } from '@/i18n';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
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

function onSelect(value: string) {
    if (SUPPORTED_LOCALES.includes(value as SupportedLocale)) {
        setLocale(value as SupportedLocale);
    }
}
</script>

<template>
    <Select :model-value="locale" @update:model-value="onSelect">
        <SelectTrigger
            :aria-label="t('language.label')"
            :class="['h-8 w-auto gap-1.5 border-none bg-transparent px-2 py-1.5 text-sm shadow-none hover:bg-accent hover:text-accent-foreground focus:ring-0', $props.class]"
        >
            <SelectValue>
                <span class="flex items-center gap-1.5">
                    <span class="text-base leading-none">{{ flags[locale as SupportedLocale] }}</span>
                    <span class="text-xs font-medium uppercase tracking-wide">{{ locale }}</span>
                </span>
            </SelectValue>
        </SelectTrigger>
        <SelectContent align="end">
            <SelectItem v-for="lang in SUPPORTED_LOCALES" :key="lang" :value="lang">
                <span class="flex items-center gap-2">
                    <span class="text-base leading-none">{{ flags[lang] }}</span>
                    <span>{{ t(`language.${lang}`) }}</span>
                </span>
            </SelectItem>
        </SelectContent>
    </Select>
</template>
