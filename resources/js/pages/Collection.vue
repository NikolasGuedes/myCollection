<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Search, Plus, Heart, Edit } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Toast from 'primevue/toast';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

import { useToast } from 'primevue/usetoast';
import Card from '@/components/ui/card/Card.vue';

const toast = useToast();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'collection',
        href: '/collection',
    },
];

const props = defineProps({
    consoles: {
        type: Array as () => Array<{
            id: number;
            name: string;
            status: string
        }>,
        required: true,
    },
    allConsoles: {
        type: Array as () => Array<{
            id: number;
            name: string;
            picture: string;
            picture_url: string | null;
        }>,
        required: true,
    }
})

const likes = ref(0);
const isDialogOpen = ref(false);

const openDialog = () => {
    isDialogOpen.value = true;
    // Reset do formulário e preview quando abrir o dialog
    consoleForm.reset();
    imagePreview.value = null;
};

const consoleForm = useForm({
    name: '',
    status: '',
});

const imagePreview = ref<string | null>(null);

watch(() => consoleForm.name, (newName) => {

    if (newName) {
        const selectedConsole = props.allConsoles.find(c => c.name === newName);

        if (selectedConsole) {
            const imageUrl = selectedConsole.picture_url || `/${selectedConsole.picture}`;
            imagePreview.value = imageUrl;
        }
    } else {
        imagePreview.value = null;
    }
});

const saveConsole = () => {
    consoleForm.post(route('collection.store'), {
        preserveState: true,
        onSuccess: () => {
            isDialogOpen.value = false;
            consoleForm.reset();
            imagePreview.value = null;
            toast.add({
                severity: 'success',
                detail: 'Console add successfully.',
                life: 4000,
            });

        },
        onError: () => {
            toast.add({
                severity: 'error',
                detail: 'An error occurred while adding the console.',
                life: 4000,
            });
        },
    });
};

const getConsoleImage = (consoleName: string): string | null => {
    const consoleData = props.allConsoles.find(c => c.name === consoleName);
    if (consoleData) {
        return consoleData.picture_url || `/${consoleData.picture}`;
    }
    return null;
};


</script>

<template>
    <Toast />

    <Head title="collection" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-fit items-start justify-between flex-row rounded-xl flex-wrap p-4 gap-4">
            <div class="flex flex-row gap-2 items-center justify-center">
                <label for="search" class="font-bold">Search: </label>
                <Input class="w-2xs"></Input>
                <Button class="cursor-pointer">
                    <Search class="h-5 w-5" />
                    Search
                </Button>
            </div>
            <div class="flex flex-row gap-4 items-center justify-center">
                <Button class="cursor-pointer" @click="openDialog">
                    <Plus class="h-5 w-5" />
                    Add new Console
                </Button>
            </div>
        </div>
        <div class="flex h-fit items-start justify-between flex-row rounded-xl p-4 self-end">
            <div class="flex flex-row gap-2 items-center justify-center">
                <Button class="cursor-pointer  bg-[var(--secondary)] text-white font-bold">
                    {{ likes }}
                    <Heart class="h-5 w-5 text-[var(--green_site)]" />
                </Button>
            </div>

        </div>

        <div v-if="consoles.length === 0"
            class="flex h-full items-center justify-start flex-1 flex-col gap-4 rounded-xl pt-10 overflow-x-auto">
            <p class="font-bold text-lg">No registered console yet.</p>
        </div>

        <div v-else
            class="flex h-full items-start justify-evenly flex-1 flex-row gap-10 rounded-xl p-5 pt-3 flex-wrap overflow-x-auto">
            <Card v-for="console in consoles" :key="console.id"
                class="bg-[var(--sidebar-background)] backdrop-blur-sm rounded-lg  overflow-hidden p-5 w-96">
                <div class="space-y-4">
                    <div class="flex justify-end">
                        <Button variant="ghost" size="icon"
                            class="h-8 w-8 p-0 bg-[var(--secondary)] text-[var(--green_site)] hover:text-[var(--green_site)] cursor-pointer">
                            <Edit />
                        </Button>
                    </div>
                    <div
                        class="relative bg-[var(--secondary)] rounded-lg aspect-[2] flex items-center justify-center overflow-hidden">
                        <img v-if="getConsoleImage(console.name)" :src="getConsoleImage(console.name)!" :alt="console.name"
                            class="w-full h-full object-cover bg-[var(--secondary)]/5" />
                        <div v-if="getConsoleImage(console.name)" class="absolute inset-0 bg-black opacity-40"></div>
                        <div v-else class="text-white text-sm">No Image</div>
                    </div>

                    <h3 class="text-white font-semibold text-center text-sm tracking-wide uppercase">
                        {{ console.name }}
                    </h3>

                    <div class="flex items-center justify-between gap-x-10">
                        <span class="text-slate-300 text-sm font-medium w-28">ESTATE:</span>
                        <span
                            class="bg-[var(--secondary)] text-white text-xs px-3 py-1 rounded-full text-center w-80 uppercase">
                            {{ console.status }}
                        </span>
                    </div>


                    <div class="flex items-center justify-between gap-x-10">
                        <span class="text-slate-300 text-sm font-medium w-28">GAMES:</span>
                        <span
                            class="bg-[var(--secondary)] text-white text-xs px-3 py-1 rounded-full text-center w-80 uppercase">
                            0
                        </span>
                    </div>


                    <div class="flex items-center justify-between gap-x-10">
                        <span class="text-slate-300 text-sm font-medium w-28">GADGETS:</span>
                        <span
                            class="bg-[var(--secondary)] text-white text-xs px-3 py-1 rounded-full text-center w-80 uppercase">
                            0
                        </span>
                    </div>


                    <Button class="w-full bg-[var(--primary)] text-white font-medium text-sm py-2 mt-4 cursor-pointer">
                        <p class="font-bold">ADD ITEM</p>
                    </Button>
                </div>
            </Card>
        </div>

        <Dialog v-model:open="isDialogOpen">
            <DialogContent class="bg-[var(--sidebar-background)] border-none min-w-3xl max-sm:min-w-fit mx-auto">
                <form @submit.prevent="saveConsole" class="space-y-6">

                    <DialogHeader class="pb-4">
                        <DialogTitle class="text-white text-lg font-semibold">New Console</DialogTitle>
                    </DialogHeader>
                    <div class="space-y-6">
                        <!-- Image Preview Area -->
                        <div class="flex flex-col items-center space-y-4 mt-6">
                            <div
                                class="relative bg-[var(--secondary)] rounded-lg aspect-[2] w-full max-w-md flex items-center justify-center overflow-hidden">
                                <img  v-if="imagePreview" :src="imagePreview" :alt="consoleForm.name"
                                    class="w-full h-full object-cover bg-[var(--secondary)]/5" />
                                <div v-if="imagePreview" class="absolute inset-0 bg-black opacity-40"></div>
                                <div v-else class="text-white text-sm">
                                    {{ consoleForm.name ? 'Loading preview...' : 'Select a console to see preview' }}
                                </div>
                            </div>
                        </div>

                        <!-- Select Console -->
                        <div>
                            <Select v-model="consoleForm.name">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select Console" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Choose a console</SelectLabel>
                                        <SelectItem v-for="console in allConsoles" :key="console.id"
                                            :value="console.name">
                                            {{ console.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <div v-if="consoleForm.errors.name" class="text-red-500 text-sm mt-2">
                                {{ consoleForm.errors.name }}
                            </div>
                        </div>

                        <!-- Select Console Status -->
                        <div>
                            <Select v-model="consoleForm.status">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Console Status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Choose a state</SelectLabel>
                                        <SelectItem value="new">
                                            NEW
                                        </SelectItem>
                                        <SelectItem value="used">
                                            USED
                                        </SelectItem>
                                        <SelectItem value="broken">
                                            BROKEN
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <div v-if="consoleForm.errors.status" class="text-red-500 text-sm mt-2">
                                {{ consoleForm.errors.status }}
                            </div>
                        </div>
                    </div>

                    <DialogFooter class="pt-3">
                        <Button type="submit"
                            class="w-full bg-[var(--primary)] text-white font-semibold py-3 rounded-lg cursor-pointer hover:bg-[var(--primary)]/90 transition-colors"
                            :disabled="consoleForm.processing">
                            {{ consoleForm.processing ? 'SAVING...' : 'ADD NEW CONSOLE' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
