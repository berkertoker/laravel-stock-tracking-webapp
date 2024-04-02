<script setup>
import { ref } from "vue";
import ManagerLayout from '@/Layouts/ManagerLayout.vue';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, usePage, router } from "@inertiajs/vue3";
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import { computed } from "vue";

// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const page = usePage();
const pond = ref(null);
const files = ref([]);
const csrf = computed(() => page.props.csrf_token);

const form = useForm({
    name: "",
    price: "",
    stock: "",
    description: "",
    images: [],
});

function handleFilePondLoad(response){
    form.images.push(response);
    return response;
}
function handleFilePondRevert(uniqueId, load, error){
    form.images = form.images.filter((image) => image !== uniqueId);
    router.delete("/revert/"+uniqueId);
    error('oh my goodness');
    load();
}
</script>

<template>
    <ManagerLayout>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <Head title="Store the Post" />

                    <form @submit.prevent="form.post(route('products.store'))">

                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="name"
                                class="mt-1 block w-full p-2 bg-slate-100 border"
                                v-model="form.name"
                                placeholder="Name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="price" value="Price" />

                            <TextInput
                                id="price"
                                type="number"
                                step="0.01"
                                class="mt-1 block w-full p-2 bg-slate-100 border"
                                v-model="form.price"
                                placeholder="Price"
                            />

                            <InputError class="mt-2" :message="form.errors.price" />
                        </div>

                        <div>
                            <InputLabel for="stock" value="Stock" />

                            <TextInput
                                id="stock"
                                type="number"
                                class="mt-1 block w-full p-2 bg-slate-100 border"
                                v-model="form.stock"
                                placeholder="Stock"
                            />

                            <InputError class="mt-2" :message="form.errors.stock" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />

                            <textarea
                                id="description"
                                rows="4"
                                v-model="form.description"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write product description here..."
                            ></textarea>

                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="mt-4">
                            <file-pond
                                id="image"
                                name="image"
                                ref="pond"
                                class-name="my-pond"
                                label-idle="Drop files here..."
                                allow-multiple="true"
                                accepted-file-types="image/jpeg, image/png"
                                :files="files"
                                :server="{
                                    process :{
                                        url: '/upload',
                                        method: 'POST',
                                        onload: handleFilePondLoad
                                    },
                                    revert: handleFilePondRevert,
                                    headers: {
                                        'X-CSRF-TOKEN': $page.props.csrf_token,
                                    },
                                }"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Create Product
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </ManagerLayout>
</template>
