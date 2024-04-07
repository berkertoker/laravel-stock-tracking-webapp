<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm} from "@inertiajs/vue3";


const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    quantity: "",
    product: ""
});


</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <Head title="Store the Stocks" />

                    <form @submit.prevent="form.post(route('stocks.store'))">

                        <div style="padding-bottom: 20px;">
                            <select
                                id="product"
                                class="mt-1 block w-full"
                                v-model="form.product"
                                required
                            >
                                <option v-for="product in products" :key="product.id" :value="product">{{ product.name }}</option>
                            </select>
                        </div>

                        <div>
                            <InputLabel for="quantity" value="Stock" />

                            <TextInput
                                id="quantity"
                                type="number"
                                class="mt-1 block w-full p-2 bg-slate-100 border"
                                v-model="form.quantity"
                                placeholder="Stock"
                            />

                            <InputError class="mt-2" :message="form.errors.quantity" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Add Stock
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
