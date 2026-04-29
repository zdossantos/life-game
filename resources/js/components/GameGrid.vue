<script setup lang="ts">
import type { Grid } from '@/types/game-of-life';
import { onMounted, onUnmounted, ref } from 'vue';

const props = defineProps<{
    grid: Grid;
    isRunning: boolean;
}>();

const emit = defineEmits(['toggle-cell']);
const isDrawing = ref(false);
const isDrawingMode = ref<boolean | null>(null);
const gridContainer = ref<HTMLElement | null>(null);

const startDrawing = (i: number, j: number) => {
    if (!props.isRunning) {
        isDrawing.value = true;
        isDrawingMode.value = props.grid[i][j].alive === 0;
        emit('toggle-cell', i, j);
    }
};

const draw = (i: number, j: number) => {
    if (isDrawing.value && !props.isRunning) {
        if (isDrawingMode.value && props.grid[i][j].alive === 0) {
            emit('toggle-cell', i, j);
        } else if (!isDrawingMode.value && props.grid[i][j].alive === 1) {
            emit('toggle-cell', i, j);
        }
    }
};

const stopDrawing = () => {
    isDrawing.value = false;
    isDrawingMode.value = null;
};

const getCellIndicesFromTouch = (touch: Touch): [number, number] | null => {
    const el = document.elementFromPoint(touch.clientX, touch.clientY) as HTMLElement | null;
    if (!el) return null;
    const row = el.dataset.row;
    const col = el.dataset.col;
    if (row === undefined || col === undefined) return null;
    return [parseInt(row), parseInt(col)];
};

const onTouchStart = (event: TouchEvent) => {
    if (props.isRunning) return;
    event.preventDefault();
    const touch = event.changedTouches[0];
    const indices = getCellIndicesFromTouch(touch);
    if (indices) startDrawing(indices[0], indices[1]);
};

const onTouchMove = (event: TouchEvent) => {
    if (!isDrawing.value || props.isRunning) return;
    event.preventDefault();
    const touch = event.changedTouches[0];
    const indices = getCellIndicesFromTouch(touch);
    if (indices) draw(indices[0], indices[1]);
};

onMounted(() => {
    const el = gridContainer.value;
    if (!el) return;
    el.addEventListener('touchstart', onTouchStart, { passive: false });
    el.addEventListener('touchmove', onTouchMove, { passive: false });
    el.addEventListener('touchend', stopDrawing);
});

onUnmounted(() => {
    const el = gridContainer.value;
    if (!el) return;
    el.removeEventListener('touchstart', onTouchStart);
    el.removeEventListener('touchmove', onTouchMove);
    el.removeEventListener('touchend', stopDrawing);
});
</script>

<template>
    <div class="flex justify-center items-center w-full h-full">
        <div
            ref="gridContainer"
            class="inline-block border border-gray-200 dark:border-gray-700 rounded-lg aspect-square"
            @mouseup="stopDrawing"
            @mouseleave="stopDrawing"
            :style="{
            height: 'min(100%, 90vw)'
        }"
        >
            <div
                v-for="(row, i) in grid"
                :key="i"
                class="flex"
                :style="`height: ${100/grid.length}%`"
            >
                <div
                    v-for="(cell, j) in row"
                    :key="j"
                    :data-row="i"
                    :data-col="j"
                    @mousedown="startDrawing(i, j)"
                    @mousemove="draw(i, j)"
                    class="aspect-square border border-gray-200 dark:border-gray-700 transition-colors duration-200"
                    :style="{
                        backgroundColor: cell.alive === 1 ? cell.color : undefined
                    }"
                    :class="[
                        cell.alive === 0 ? 'bg-white dark:bg-black hover:bg-gray-100 dark:hover:bg-gray-500' : '',
                        { 'cursor-not-allowed': isRunning },
                        { 'cursor-pointer': !isRunning }
                    ]"
                ></div>
            </div>
        </div>
    </div>
</template>
