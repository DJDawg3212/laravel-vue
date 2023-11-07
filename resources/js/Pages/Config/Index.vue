<script setup>
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Proceso from './Proceso.vue';
import Tipo from './TipoDoc.vue';

const props = defineProps({
    procesos: { typeof: Object },
    tipoDocs: { typeof: Object }
});

</script>

<template>
    <Head title="Configuraciones" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Configuraciones</h2>
        </template>

        <div class="ml-5 mr-5">
            <div class="mt-12 row">
                <div class="col-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                        <Proceso :data="procesos" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                        <Tipo :data="tipoDocs" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


