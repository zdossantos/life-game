<script setup lang="ts">
import GameControls from '@/components/GameControls.vue';
import GameGrid from '@/components/GameGrid.vue';
import type { GameSettings, Grid } from '@/types/game-of-life';
import { Head } from '@inertiajs/vue3';
import { onUnmounted, ref, watch } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    id?: string,
    settings?: GameSettings,
    grid?: Grid,
    cycleCount?: number
}>();

const settings = ref<GameSettings>(
    props.settings || {
        gridSize: 20,
        updateSpeed: 500,
        selectedColor: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#000000',
        neighborThresholds: {
            surviveMin: 2,
            surviveMax: 3,
            birthCount: 3,
        },
    },
);

const grid = ref<Grid>(props.grid || createEmptyGrid(settings.value.gridSize));
const cycleCount = ref(props.cycleCount || 0);
const isRunning = ref(false);
let intervalId: ReturnType<typeof setInterval> | null = null;

function createEmptyGrid(size: number): Grid {
    return Array(size)
        .fill(0)
        .map(() =>
            Array(size)
                .fill(0)
                .map(() => ({
                    alive: 0,
                    color: settings.value.selectedColor,
                })),
        );
}

const toggleCell = (row: number, col: number) => {
    if (!isRunning.value) {
        const cell = grid.value[row][col];
        cell.alive = cell.alive === 1 ? 0 : 1;
        if (cell.alive === 1) {
            cell.color = settings.value.selectedColor;
        }
    }
};

const calculateNextGeneration = () => {
    cycleCount.value++;
    const newGrid = grid.value.map((row) => row.map((cell) => ({ ...cell })));

    for (let i = 0; i < settings.value.gridSize; i++) {
        for (let j = 0; j < settings.value.gridSize; j++) {
            const neighbors = countNeighbors(i, j);
            const neighborColors = getNeighborColors(i, j);

            if (grid.value[i][j].alive === 1) {
                newGrid[i][j].alive =
                    neighbors >= settings.value.neighborThresholds.surviveMin && neighbors <= settings.value.neighborThresholds.surviveMax ? 1 : 0;
            } else {
                newGrid[i][j].alive = neighbors === settings.value.neighborThresholds.birthCount ? 1 : 0;
                if (newGrid[i][j].alive === 1) {
                    newGrid[i][j].color = blendColors(neighborColors);
                }
            }
        }
    }

    grid.value = newGrid;
};

const countNeighbors = (row: number, col: number): number => {
    let count = 0;
    for (let i = -1; i <= 1; i++) {
        for (let j = -1; j <= 1; j++) {
            if (i === 0 && j === 0) continue;
            const newRow = row + i;
            const newCol = col + j;
            if (newRow >= 0 && newRow < settings.value.gridSize && newCol >= 0 && newCol < settings.value.gridSize) {
                count += grid.value[newRow][newCol].alive;
            }
        }
    }
    return count;
};

const getNeighborColors = (row: number, col: number): string[] => {
    const colors: string[] = [];
    for (let i = -1; i <= 1; i++) {
        for (let j = -1; j <= 1; j++) {
            if (i === 0 && j === 0) continue;
            const newRow = row + i;
            const newCol = col + j;
            if (
                newRow >= 0 &&
                newRow < settings.value.gridSize &&
                newCol >= 0 &&
                newCol < settings.value.gridSize &&
                grid.value[newRow][newCol].alive === 1
            ) {
                colors.push(grid.value[newRow][newCol].color);
            }
        }
    }
    return colors;
};

const blendColors = (colors: string[]): string => {
    if (colors.length === 0) return settings.value.selectedColor;

    const rgbColors = colors.map((color) => {
        const r = parseInt(color.slice(1, 3), 16);
        const g = parseInt(color.slice(3, 5), 16);
        const b = parseInt(color.slice(5, 7), 16);
        return [r, g, b];
    });

    const avgColor = rgbColors
        .reduce((acc, curr) => [acc[0] + curr[0], acc[1] + curr[1], acc[2] + curr[2]])
        .map((c) => Math.round(c / rgbColors.length));

    return `#${avgColor.map((c) => c.toString(16).padStart(2, '0')).join('')}`;
};

const toggleSimulation = () => {
    isRunning.value = !isRunning.value;
    if (isRunning.value) {
        intervalId = setInterval(calculateNextGeneration, settings.value.updateSpeed);
    } else if (intervalId) {
        clearInterval(intervalId);
    }
};

const updateSettings = (newSettings: GameSettings) => {
    if (newSettings.gridSize !== settings.value.gridSize) {
        grid.value = createEmptyGrid(newSettings.gridSize);
    }
    settings.value = newSettings;

    if (isRunning.value && intervalId) {
        clearInterval(intervalId);
        intervalId = setInterval(calculateNextGeneration, settings.value.updateSpeed);
    }
};

const resetGrid = () => {
    grid.value = createEmptyGrid(settings.value.gridSize);
    cycleCount.value = 0;
    if (isRunning.value) {
        toggleSimulation();
    }
};

watch(
    () => settings.value.updateSpeed,
    (newSpeed) => {
        if (isRunning.value && intervalId) {
            clearInterval(intervalId);
            intervalId = setInterval(calculateNextGeneration, newSpeed);
        }
    },
);

onUnmounted(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
});
</script>

<template>
    <AppLayout>
        <Head :title="t('game.title')" />
        <div class="flex min-h-0 flex-1 flex-col overflow-hidden">
            <!-- Page header bar -->
            <div class="flex items-center justify-between border-b border-border/60 bg-muted/30 px-4 py-2">
                <div>
                    <h1 class="text-lg font-semibold tracking-tight">{{ t('game.title') }}</h1>
                    <p class="text-xs text-muted-foreground">{{ t('game.cycles', { count: cycleCount }) }}</p>
                </div>

                <GameControls
                    :is-running="isRunning"
                    :settings="settings"
                    :grid="grid"
                    :id="props.id"
                    :cycle-count="cycleCount"
                    @toggle-simulation="toggleSimulation"
                    @update-settings="updateSettings"
                    @reset="resetGrid"
                />
            </div>

            <!-- Game grid area -->
            <div class="flex min-h-0 flex-1 items-center justify-center p-4">
                <GameGrid :grid="grid" :is-running="isRunning" @toggle-cell="toggleCell" />
            </div>
        </div>
    </AppLayout>
</template>
