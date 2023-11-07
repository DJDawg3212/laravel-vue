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
    tip_nombre: '',
    tip_prefijo: ''
});

const formUpdate = useForm({
    tip_nombre: '',
    tip_prefijo: ''
});

const alert = (msj, icon = "success") => {
    Swal.fire({
        title: msj,
        icon: icon
    })
}

const startEditing = (tipo) => {
    editingRowId.value = tipo.id;
    formUpdate.tip_prefijo = tipo.tip_prefijo;
    formUpdate.tip_nombre = tipo.tip_nombre;
};

const createTypeDoc = () => {
    formCreate.post(route('type_docStore'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Tipo Creado Correctamente');
            addCol.value = false;
            formCreate.reset();
        },
        onError: () => {
            alert('Sucedio Un Error', "error");
        }
    });
};

const updateTypeDoc = () => {
    formUpdate.put(route('type_docUpdate', editingRowId.value), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Tipo Actualizado Correctamente');
            editingRowId.value = null;
            formUpdate.reset()
        },
        onError: () => {
            alert('Sucedio Un Error', "error");
        }
    });
};

const deleteTypeDoc = (id, name) => {
    const alertDelete = Swal.mixin({
        buttonsStyling: true
    });
    alertDelete.fire({
        title: `¿Seguro Quieres Eliminar El Tipo ${name}?`,
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> ¡Si, Eliminar!',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((response) => {
        if (response.isConfirmed) {
            formDelete.delete(route('type_docDestroy', id), {
                onSuccess: (res) => {
                    alert('Tipo Eliminado Correctamente');
                },
                onError: (error) => {
                    alert('Error al eliminar el tipo: ' + error.response.data.message, 'error');
                }
            });
        }
    });
}

</script>

<template>
    <div class="row d-flex space-between">
        <h2 class="col-6">
            Tipo
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
                        <TextInput v-model="formCreate.tip_prefijo" id="tip_prefijo" type="text" class="mt-1 block w-3/4"
                            placeholder="___" maxlength="3" />
                        <InputError :message="formCreate.errors.tip_prefijo" class="mt-2" />
                    </td>
                    <td>
                        <TextInput v-model="formCreate.tip_nombre" id="tip_nombre" type="text" class="mt-1 block w-3/4"
                            placeholder="____________" />
                        <InputError :message="formCreate.errors.tip_nombre" class="mt-2" />
                    </td>
                    <td>
                        <div class="btn-group mr-2" role="group">
                            <button class="btn btn-success" @click.prevent="createTypeDoc()">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button class="btn btn-danger" @click="addCol = false">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr v-for="tipo in data" :key="tipo.id">
                    <th scope="row">{{ tipo.id }}</th>
                    <td>
                        <template v-if="editingRowId == tipo.id">
                            <TextInput v-model="formUpdate.tip_prefijo" id="tip_prefijo" type="text"
                                class="mt-1 block w-3/4" :placeholder="tipo.tip_prefijo" />
                            <InputError :message="formUpdate.errors.tip_prefijo" class="mt-2" />
                        </template>
                        <template v-else>
                            {{ tipo.tip_prefijo }}
                        </template>
                    </td>
                    <td>
                        <template v-if="editingRowId == tipo.id">
                            <TextInput v-model="formUpdate.tip_nombre" id="tip_nombre" type="text" class="mt-1 block w-3/4"
                                :placeholder="tipo.tip_nombre" />
                            <InputError :message="formUpdate.errors.tip_nombre" class="mt-2" />
                        </template>
                        <template v-else>
                            {{ tipo.tip_nombre }}
                        </template>
                    </td>
                    <td>
                        <div class="btn-group mr-2" v-if="editingRowId == tipo.id">
                            <button class="btn btn-success" @click.prevent="updateTypeDoc()">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button class="btn btn-danger" @click="editingRowId = false">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                        <div class="btn-group mr-2" v-else>
                            <button class="btn btn-info" @click.prevent="startEditing(tipo)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger" @click="deleteTypeDoc(tipo.id, tipo.tip_nombre)">
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