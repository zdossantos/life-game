<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Slider } from '@/components/ui/slider';
import { Input } from '@/components/ui/input';
import type { GameSettings, Grid } from '@/types/game-of-life';
import { router, usePage } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import { toast } from 'vue-sonner';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    id?: string;
    grid: Grid;
    isRunning: boolean;
    settings: GameSettings;
    cycleCount: number;
}>();

const emit = defineEmits<{
    'toggle-simulation': [];
    'update-settings': [settings: GameSettings];
    reset: [];
}>();

watch(
    () => props.grid,
    (newGrid) => {
        updateSettings('grid', newGrid);
    },
    { deep: true },
);

const updateSettings = (key: keyof GameSettings, value: any) => {
    emit('update-settings', {
        ...props.settings,
        [key]: value,
    });
};

const saveSettings = () => {
    router.post(route('save.store'), {
        id: props.id,
        grid:  props.grid,
        grid_size: props.settings.gridSize,
        update_speed: props.settings.updateSpeed,
        neighbor_thresholds: props.settings.neighborThresholds,
        selected_color: props.settings.selectedColor,
        cycle_count: props.cycleCount,
    }, {
        onSuccess: () => {
            toast.success(t('game.savedSuccess'));
        },
        onError: (errors) => {
            console.error('Save error:', errors);
        }
    });
};
const page = usePage();
const auth = computed(() => page.props.auth);
</script>

<template>
    <div class="w-full max-w-md space-y-4">
        <div class="flex items-center justify-between gap-4">
            <Button @click="$emit('toggle-simulation')" variant="default">
                {{ isRunning ? t('game.stop') : t('game.start') }}
            </Button>
            <Button @click="$emit('reset')" variant="outline">{{ t('game.reset') }}</Button>
            <Button @click="saveSettings" variant="outline" v-if="auth.user">{{ t('game.save') }}</Button>

            <Input
                type="color"
                :model-value="settings.selectedColor"
                @update:model-value="(v) => updateSettings('selectedColor', v)"
                class="h-10 w-20"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium leading-none">{{ t('game.gridSize', { size: settings.gridSize }) }}</label>
            <Slider
                :model-value="[settings.gridSize]"
                @update:model-value="(v: any) => updateSettings('gridSize', v[0])"
                :min="10"
                :max="50"
                :step="1"
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium leading-none">{{ t('game.speed', { speed: settings.updateSpeed }) }}</label>
            <Slider
                :model-value="[settings.updateSpeed]"
                @update:model-value="(v: any) => updateSettings('updateSpeed', v[0])"
                :min="100"
                :max="1000"
                :step="100"
            />
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-medium leading-none">{{ t('game.surviveMin') }}</label>
                <Input
                    type="number"
                    :model-value="settings.neighborThresholds.surviveMin"
                    @update:model-value="
                        (v) =>
                            updateSettings('neighborThresholds', {
                                ...settings.neighborThresholds,
                                surviveMin: parseInt(v as string),
                            })
                    "
                    min="0"
                    max="8"
                />
            </div>
            <div>
                <label class="text-sm font-medium leading-none">{{ t('game.surviveMax') }}</label>
                <Input
                    type="number"
                    :model-value="settings.neighborThresholds.surviveMax"
                    @update:model-value="
                        (v) =>
                            updateSettings('neighborThresholds', {
                                ...settings.neighborThresholds,
                                surviveMax: parseInt(v as string),
                            })
                    "
                    min="0"
                    max="8"
                />
            </div>
            <div>
                <label class="text-sm font-medium leading-none">{{ t('game.birth') }}</label>
                <Input
                    type="number"
                    :model-value="settings.neighborThresholds.birthCount"
                    @update:model-value="
                        (v) =>
                            updateSettings('neighborThresholds', {
                                ...settings.neighborThresholds,
                                birthCount: parseInt(v as string),
                            })
                    "
                    min="0"
                    max="8"
                />
            </div>
        </div>
    </div>
</template>
