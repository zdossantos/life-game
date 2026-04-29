<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Slider } from '@/components/ui/slider';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import type { GameSettings, Grid } from '@/types/game-of-life';
import { router, usePage } from '@inertiajs/vue3';
import { Play, RotateCcw, Save, Square } from 'lucide-vue-next';
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
    <div class="space-y-6">

        <!-- ── Actions ────────────────────────────────────────────────── -->
        <div class="space-y-2">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-muted-foreground">
                {{ t('game.actions') }}
            </p>
            <div class="flex gap-2">
                <Button
                    class="flex-1 gap-1.5"
                    :variant="isRunning ? 'destructive' : 'default'"
                    @click="$emit('toggle-simulation')"
                >
                    <Square v-if="isRunning" class="h-3.5 w-3.5" />
                    <Play v-else class="h-3.5 w-3.5" />
                    {{ isRunning ? t('game.stop') : t('game.start') }}
                </Button>
                <Button variant="outline" size="icon" :title="t('game.reset')" @click="$emit('reset')">
                    <RotateCcw class="h-4 w-4" />
                </Button>
                <Button v-if="auth.user" variant="outline" size="icon" :title="t('game.save')" @click="saveSettings">
                    <Save class="h-4 w-4" />
                </Button>
            </div>
        </div>

        <Separator />

        <!-- ── Appearance ─────────────────────────────────────────────── -->
        <div class="space-y-3">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-muted-foreground">
                {{ t('game.appearance') }}
            </p>
            <div class="flex items-center justify-between">
                <Label class="text-sm font-normal">{{ t('game.color') }}</Label>
                <input
                    type="color"
                    :value="settings.selectedColor"
                    @input="(e) => updateSettings('selectedColor', (e.target as HTMLInputElement).value)"
                    class="h-8 w-12 cursor-pointer rounded-md border border-border bg-transparent p-0.5"
                />
            </div>
        </div>

        <Separator />

        <!-- ── Grid ───────────────────────────────────────────────────── -->
        <div class="space-y-3">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-muted-foreground">
                {{ t('game.gridSettings') }}
            </p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <Label class="text-sm font-normal">{{ t('game.gridSizeLabel') }}</Label>
                    <span class="tabular-nums text-sm font-semibold">{{ settings.gridSize }}</span>
                </div>
                <Slider
                    :model-value="[settings.gridSize]"
                    @update:model-value="(v: any) => updateSettings('gridSize', v[0])"
                    :min="10"
                    :max="50"
                    :step="1"
                />
            </div>
        </div>

        <Separator />

        <!-- ── Speed ──────────────────────────────────────────────────── -->
        <div class="space-y-3">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-muted-foreground">
                {{ t('game.simSpeed') }}
            </p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <Label class="text-sm font-normal">{{ t('game.speedLabel') }}</Label>
                    <span class="tabular-nums text-sm font-semibold">{{ settings.updateSpeed }} ms</span>
                </div>
                <Slider
                    :model-value="[settings.updateSpeed]"
                    @update:model-value="(v: any) => updateSettings('updateSpeed', v[0])"
                    :min="100"
                    :max="1000"
                    :step="100"
                />
            </div>
        </div>

        <Separator />

        <!-- ── Rules ──────────────────────────────────────────────────── -->
        <div class="space-y-3">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-muted-foreground">
                {{ t('game.rules') }}
            </p>
            <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1.5">
                    <Label class="text-xs text-muted-foreground">{{ t('game.surviveMin') }}</Label>
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
                        class="text-center"
                    />
                </div>
                <div class="space-y-1.5">
                    <Label class="text-xs text-muted-foreground">{{ t('game.surviveMax') }}</Label>
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
                        class="text-center"
                    />
                </div>
                <div class="space-y-1.5">
                    <Label class="text-xs text-muted-foreground">{{ t('game.birth') }}</Label>
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
                        class="text-center"
                    />
                </div>
            </div>
        </div>

    </div>
</template>
