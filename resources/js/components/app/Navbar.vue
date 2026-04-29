<script setup lang="ts">
import UserMenuContent from '@/components/dashboard/UserMenuContent.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Drawer, DrawerClose, DrawerContent, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';
import { getInitials } from '@/composables/useInitials';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutDashboard, LogIn, Menu, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Auth } from '@/types';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

const page = usePage();
const auth = computed(() => page.props.auth as Auth);
const { t } = useI18n();

const mobileMenuOpen = ref(false);
</script>

<template>
    <nav class="flex h-14 w-full items-center justify-between border-b border-border bg-background/95 px-4 shadow-sm backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <Link :href="route('home')" class="flex items-center gap-2.5 transition-opacity hover:opacity-80">
            <div class="flex h-7 w-7 items-center justify-center overflow-hidden rounded-md bg-primary">
                <AppLogoIcon class="size-6 rounded" />
            </div>
            <span class="text-sm font-semibold tracking-tight">Life Game</span>
        </Link>

        <!-- Desktop actions -->
        <div class="hidden items-center gap-2 sm:flex">
            <LanguageSwitcher />

            <DropdownMenu v-if="auth.user">
                <DropdownMenuTrigger :as-child="true">
                    <Button variant="ghost" size="icon" class="relative size-9 rounded-full focus-within:ring-2 focus-within:ring-primary">
                        <Avatar class="size-8 overflow-hidden rounded-full">
                            <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                            <AvatarFallback class="rounded-full bg-primary/10 text-sm font-semibold text-primary">
                                {{ getInitials(auth.user.name) }}
                            </AvatarFallback>
                        </Avatar>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" class="w-56">
                    <UserMenuContent :user="auth.user" />
                    <DropdownMenuSeparator />
                    <DropdownMenuItem :as-child="true">
                        <Link class="block w-full" href="/dashboard">
                            <LayoutDashboard class="mr-2 h-4 w-4" />
                            {{ t('nav.dashboard') }}
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <Button v-else variant="outline" size="sm" :as-child="true">
                <Link href="/login" class="flex items-center gap-1.5">
                    <LogIn class="h-4 w-4" />
                    {{ t('login.submit') }}
                </Link>
            </Button>
        </div>

        <!-- Mobile hamburger + Drawer -->
        <div class="flex items-center gap-2 sm:hidden">
            <LanguageSwitcher />

            <Drawer v-model:open="mobileMenuOpen">
                <DrawerTrigger as-child>
                    <Button variant="ghost" size="icon" class="size-9" :aria-label="t('nav.menu')">
                        <Menu v-if="!mobileMenuOpen" class="h-5 w-5" />
                        <X v-else class="h-5 w-5" />
                    </Button>
                </DrawerTrigger>
                <DrawerContent class="px-4 pb-8">
                    <DrawerHeader class="text-left">
                        <DrawerTitle>Life Game</DrawerTitle>
                    </DrawerHeader>

                    <nav class="mt-2 flex flex-col gap-1">
                        <template v-if="auth.user">
                            <!-- User info -->
                            <div class="mb-3 flex items-center gap-3 rounded-lg bg-muted/50 px-3 py-2.5">
                                <Avatar class="size-9 overflow-hidden rounded-full">
                                    <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                                    <AvatarFallback class="rounded-full bg-primary/10 text-sm font-semibold text-primary">
                                        {{ getInitials(auth.user.name) }}
                                    </AvatarFallback>
                                </Avatar>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold">{{ auth.user.name }}</p>
                                    <p class="truncate text-xs text-muted-foreground">{{ auth.user.email }}</p>
                                </div>
                            </div>

                            <DrawerClose as-child>
                                <Link
                                    href="/dashboard"
                                    class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-muted"
                                >
                                    <LayoutDashboard class="h-4 w-4" />
                                    {{ t('nav.dashboard') }}
                                </Link>
                            </DrawerClose>
                        </template>

                        <template v-else>
                            <DrawerClose as-child>
                                <Link
                                    href="/login"
                                    class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-muted"
                                >
                                    <LogIn class="h-4 w-4" />
                                    {{ t('login.submit') }}
                                </Link>
                            </DrawerClose>
                        </template>
                    </nav>
                </DrawerContent>
            </Drawer>
        </div>
    </nav>
</template>
