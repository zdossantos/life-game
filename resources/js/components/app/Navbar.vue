<script setup lang="ts">
import UserMenuContent from '@/components/dashboard/UserMenuContent.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';
import { getInitials } from '@/composables/useInitials';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutDashboard, LogIn } from 'lucide-vue-next';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Auth } from '@/types';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

const page = usePage();
const auth = computed(() => page.props.auth as Auth);
const { t } = useI18n();
</script>

<template>
    <nav class="flex h-14 w-full items-center justify-between border-b border-border bg-background/95 px-4 shadow-sm backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <Link :href="route('home')" class="flex items-center gap-2.5 transition-opacity hover:opacity-80">
            <div class="flex h-7 w-7 items-center justify-center overflow-hidden rounded-md bg-primary">
                <AppLogoIcon class="size-6 rounded" />
            </div>
            <span class="text-sm font-semibold tracking-tight">Life Game</span>
        </Link>

        <div class="flex items-center gap-2">
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
    </nav>
</template>
