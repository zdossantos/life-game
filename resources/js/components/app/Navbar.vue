<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Monitor, Moon, Sun } from 'lucide-vue-next';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const { appearance, updateAppearance } = useAppearance();
const tabs = [
    { value: 'light', Icon: Sun, label: 'Light' },
    { value: 'dark', Icon: Moon, label: 'Dark' },
    { value: 'system', Icon: Monitor, label: 'System' },
] as const;
</script>

<template>
    <nav class="flex justify-between items-center h-12 w-full bg-black/20 dark:bg-white/20 px-4">
        <div>Game of Life</div>

        <Select v-model="appearance" @update:modelValue="updateAppearance">
            <SelectTrigger class="w-[180px]">
                <SelectValue :placeholder="tabs.find(tab => tab.value === appearance)?.label" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem v-for="{ value, Icon, label } in tabs" :key="value" :value="value">
                    <div class="flex items-center">
                        <component :is="Icon" class="h-4 w-4" />
                        <span class="ml-2">{{ label }}</span>
                    </div>
                </SelectItem>
            </SelectContent>
        </Select>
    </nav>
</template>
