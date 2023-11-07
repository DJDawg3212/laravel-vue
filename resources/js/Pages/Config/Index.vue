<script setup>
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Proceso from './Proceso.vue';
import Tipo from './TipoDoc.vue';

</script>

<template>
    <Head title="Configuraciones" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Configuraciones</h2>
        </template>

        <div class="container">
            <div class="mt-12 row">
                <div class="col-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                        <Proceso />
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                        <Tipo />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


