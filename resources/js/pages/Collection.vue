<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from '@/components/ui/dialog';
import { Search, Plus, Heart } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'collection',
        href: '/collection',
    },
];

// const props = defineProps({
//     consoles:{
//         type: Object,
//         required: true, 
//     }
// })

const likes = ref(0);
const isDialogOpen = ref(false);

const openDialog = () => {
    isDialogOpen.value = true;
};

const consoleForm = useForm({
    name: '',
    status: '',
    picture: null as File | null,
});

const saveConsole = () => {
    consoleForm.post(route('collection.store'), {
        preserveState: true,
        onSuccess: () => {
            isDialogOpen.value = false;
            consoleForm.reset();
           
        },
        onError: (errors) => {
            console.error('Failed to save console:', errors);
        },
    });
};

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0] || null;
    consoleForm.picture = file;
};

</script>

<template>

    <Head title="collection" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-fit items-start justify-between flex-row rounded-xl p-4">
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
                <Button class="cursor-pointer">
                    {{ likes }}
                    <Heart class="h-5 w-5" />
                </Button>
            </div>

        </div>

        <div class="flex h-full items-center justify-start flex-1 flex-col gap-4 rounded-xl p-4 pt-10 overflow-x-auto">
            No registered console
        </div>

        <Dialog v-model:open="isDialogOpen">
            <DialogContent>
                <form @submit.prevent="saveConsole">
                    <DialogHeader>
                        <DialogTitle>Add Console</DialogTitle>
                    </DialogHeader>
                    <div class="py-4">
                        <Input type="file" accept="image/*" @change="handleFileChange" class="mb-4" />
                        <div v-if="consoleForm.errors.picture" class="text-red-500 text-sm mb-2">
                            {{ consoleForm.errors.picture }}
                        </div>
                        <Input type="text" v-model="consoleForm.name" placeholder="Console Name" class="mb-4" />
                        <div v-if="consoleForm.errors.name" class="text-red-500 text-sm mb-2">
                            {{ consoleForm.errors.name }}
                        </div>
                        <Input type="text" v-model="consoleForm.status" placeholder="Console Status" class="mb-4" />
                        <div v-if="consoleForm.errors.status" class="text-red-500 text-sm mb-2">
                            {{ consoleForm.errors.status }}
                        </div>
                    </div>
                    <DialogFooter>

                        <Button type="submit" class="text-white cursor-pointer" :disabled="consoleForm.processing">
                            {{ consoleForm.processing ? 'Saving...' : 'Save' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
        <Toaster position="bottom-left" />
    </AppLayout>
</template>
