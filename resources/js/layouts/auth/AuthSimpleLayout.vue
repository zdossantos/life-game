<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();

// Static Game of Life "Pulsar" inspired decorative cell pattern (13×13)
const pattern = [
    0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
    1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1,
    1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1,
    1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1,
    0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0,
    1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1,
    1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1,
    1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1,
    0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
    0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0,
];
</script>

<template>
    <div class="flex min-h-svh bg-background">
        <!-- Left branding panel — hidden on mobile -->
        <div class="relative hidden overflow-hidden bg-zinc-950 text-white lg:flex lg:w-5/12 lg:flex-col lg:justify-between lg:p-12">
            <!-- Subtle dot-grid background -->
            <div class="auth-dot-grid pointer-events-none absolute inset-0" />

            <!-- Decorative GOL cell grid centered in panel -->
            <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
                <div class="grid gap-2 opacity-30" style="grid-template-columns: repeat(13, 1rem)">
                    <div
                        v-for="(alive, i) in pattern"
                        :key="i"
                        :class="['h-4 w-4 rounded-sm', alive ? 'bg-white' : 'bg-white/8']"
                    />
                </div>
            </div>

            <!-- Brand identity -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20">
                    <AppLogoIcon class="size-5 fill-current text-white" />
                </div>
                <span class="text-lg font-semibold tracking-tight">Life Game</span>
            </div>

            <!-- Tagline -->
            <div class="relative z-10 space-y-3">
                <p class="text-2xl font-light leading-snug text-zinc-100">
                    <span class="block">Simulez la vie,</span>
                    <span class="block">cycle après cycle.</span>
                </p>
                <p class="text-sm text-zinc-500">Inspiré du jeu de la vie de Conway</p>
            </div>
        </div>

        <!-- Right form panel -->
        <div class="flex flex-1 flex-col items-center justify-center p-8">
            <div class="w-full max-w-sm space-y-8">
                <!-- Logo — visible only on mobile -->
                <div class="flex flex-col items-center gap-4 lg:hidden">
                    <Link :href="route('home')">
                        <AppLogoIcon class="size-10 fill-current text-foreground" />
                    </Link>
                </div>

                <!-- Page title + description -->
                <div class="space-y-1.5">
                    <h1 class="text-2xl font-semibold tracking-tight">{{ title }}</h1>
                    <p class="text-sm text-muted-foreground">{{ description }}</p>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>
