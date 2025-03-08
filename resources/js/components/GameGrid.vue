<script setup lang="ts">
import type { Grid } from '@/types/game-of-life';
import { ref } from 'vue';

const props = defineProps<{
    grid: Grid;
    isRunning: boolean;
}>();

const emit = defineEmits(['toggle-cell']);
const isDrawing = ref(false);
const isDrawingMode = ref<boolean | null>(null);
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
</script>

<template>
    <div class="flex justify-center items-center w-full h-full">
        <div
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
