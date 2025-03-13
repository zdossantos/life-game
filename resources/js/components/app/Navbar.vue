<script setup lang="ts">
import UserMenuContent from '@/components/dashboard/UserMenuContent.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { getInitials } from '@/composables/useInitials';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutDashboard,LogIn } from 'lucide-vue-next';
import { computed } from 'vue';
import { Auth } from '@/types';

const page = usePage();
const auth = computed(() => page.props.auth as Auth);
</script>

<template>
    <nav class="flex h-12 w-full items-center justify-between bg-black/20 px-4 dark:bg-white/20">
        <div>Game of Life</div>

        <DropdownMenu v-if="auth.user">
            <DropdownMenuTrigger :as-child="true">
                <Button variant="ghost" size="icon" class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary">
                    <Avatar class="size-8 overflow-hidden rounded-full">
                        <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                        <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
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
                        Dashboard
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
        <Link v-else href="/login" class="flex items-center gap-x-2">
            <LogIn/>
            Login
        </Link>
    </nav>
</template>
