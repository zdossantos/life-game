<script setup lang="ts">
import type { Grid } from '@/types/game-of-life'

defineProps<{
    grid: Grid;
    isRunning: boolean;
}>();

const emit = defineEmits<{
    'toggle-cell': [row: number, col: number];
}>();
</script>

<template>
    <div class="inline-block border border-gray-200 rounded-lg overflow-hidden">
        <div v-for="(row, i) in grid" :key="i" class="flex">
            <div
                v-for="(cell, j) in row"
                :key="j"
                @click="$emit('toggle-cell', i, j)"
                class="w-5 h-5 border border-gray-200 transition-colors duration-200"
                :style="cell.alive === 1 ? { backgroundColor: cell.color } : {}"
                :class="[
                    cell.alive === 0 ? 'bg-white hover:bg-gray-100' : '',
                    { 'cursor-not-allowed': isRunning },
                    { 'cursor-pointer': !isRunning }
                ]"
            ></div>
        </div>
    </div>
</template>
