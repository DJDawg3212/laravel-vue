<script setup>
import Swal from 'sweetalert2';

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    data: { typeof: Object }
});

const addCol = ref(false);
const editingRowId = ref(null);

const formDelete = useForm({
    id: ''
});

const formCreate = useForm({
    pro_nombre: '',
    pro_prefijo: ''
});

const formUpdate = useForm({
    pro_nombre: '',
    pro_prefijo: ''
});

const alert = (msj, icon = "success") => {
    Swal.fire({
        title: msj,
        icon: icon
    })
}

const startEditing = (proceso) => {
    editingRowId.value = proceso.id;
    formUpdate.pro_prefijo = proceso.pro_prefijo;
    formUpdate.pro_nombre = proceso.pro_nombre;
};

const createProcess = () => {
    formCreate.post(route('processStore'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Proceso Creado Correctamente');
            addCol.value = false;
            formCreate.reset();
        },
        onError: () => {
            alert('Sucedio Un Error', "error");
        }
    });
};

const updateProcess = () => {
    formUpdate.put(route('processUpdate', editingRowId.value), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Proceso Actualizado Correctamente');
            editingRowId.value = null;
            formUpdate.reset()
        },
        onError: () => {
            alert('Sucedio Un Error', "error");
        }
    });
};

const deleteProcess = (id, name) => {
    const alertDelete = Swal.mixin({
        buttonsStyling: true
    });
    alertDelete.fire({
        title: `¿Seguro Quieres Eliminar El Proceso ${name}?`,
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> ¡Si, Eliminar!',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((response) => {
        if (response.isConfirmed) {
            formDelete.delete(route('processDestroy', id), {
                onSuccess: (res) => {
                    alert('Proceso Eliminado Correctamente');
                },
                onError: (error) => {
                    alert('Error al eliminar el proceso: ' + error.response.data.message, 'error');
                }
            });
        }
    });
}

</script>

<template>
    <div class="row d-flex space-between">
        <h2 class="col-6">
            Proceso
        </h2>
        <button class="btn btn-success col-4" @click.prevent="addCol = true">
            <i class="fa-solid fa-plus"></i> Agregar
        </button>
    </div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Prefijo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="addCol">
                    <th scope="row"></th>
                    <td>
                        <TextInput v-model="formCreate.pro_prefijo" id="pro_prefijo" type="text" class="mt-1 block w-3/4"
                            placeholder="___" maxlength="3" />
                        <InputError :message="formCreate.errors.pro_prefijo" class="mt-2" />
                    </td>
                    <td>
                        <TextInput v-model="formCreate.pro_nombre" id="pro_nombre" type="text" class="mt-1 block w-3/4"
                            placeholder="____________" />
                        <InputError :message="formCreate.errors.pro_nombre" class="mt-2" />
                    </td>
                    <td>
                        <div class="btn-group mr-2" role="group">
                            <button class="btn btn-success" @click.prevent="createProcess()">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button class="btn btn-danger" @click="addCol = false">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr v-for="proceso in data" :key="proceso.id">
                    <th scope="row">{{ proceso.id }}</th>
                    <td>
                        <template v-if="editingRowId == proceso.id">
                            <TextInput v-model="formUpdate.pro_prefijo" id="pro_prefijo" type="text"
                                class="mt-1 block w-3/4" :placeholder="proceso.pro_prefijo" />
                            <InputError :message="formUpdate.errors.pro_prefijo" class="mt-2" />
                        </template>
                        <template v-else>
                            {{ proceso.pro_prefijo }}
                        </template>
                    </td>
                    <td>
                        <template v-if="editingRowId == proceso.id">
                            <TextInput v-model="formUpdate.pro_nombre" id="pro_nombre" type="text" class="mt-1 block w-3/4"
                                :placeholder="proceso.pro_nombre" />
                            <InputError :message="formUpdate.errors.pro_nombre" class="mt-2" />
                        </template>
                        <template v-else>
                            {{ proceso.pro_nombre }}
                        </template>
                    </td>
                    <td>
                        <div class="btn-group mr-2" v-if="editingRowId == proceso.id">
                            <button class="btn btn-success" @click.prevent="updateProcess()">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button class="btn btn-danger" @click="editingRowId = false">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                        <div class="btn-group mr-2" v-else>
                            <button class="btn btn-info" @click.prevent="startEditing(proceso)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger" @click="deleteProcess(proceso.id, proceso.pro_nombre)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                        <div class="btn-group mr-2" role="group">

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>