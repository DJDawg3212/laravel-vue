<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { onMounted } from 'vue';
import { computed } from 'vue';

const props = defineProps({
    documents: { typeof: Object },
    tipoDocs: { typeof: Object },
    procesos: { typeof: Object },
    lastDocumentId: { typeof: String }
});

const modal = ref(false);
const op = ref('');
const code_id = ref('');
const modalConfig = ref({
    title: "",
    buttonTitle: "",
});

const form = useForm({
    id: '',
    codigo: '',
    nombre: '',
    contenido: '',
    proceso_id: '1',
    tipo_doc_id: '1'
});

const formDelete = useForm({
    id: ''
});

onMounted(() => {
    code_id.value = props.lastDocumentId + 1;
})

const codigoInput = computed(() => {
    const tipoDoc = props.tipoDocs.find((tipo) => tipo.id == form.tipo_doc_id);
    const proceso = props.procesos.find((proceso) => proceso.id == form.proceso_id);
    if (op.value == 'add') {
        return tipoDoc.tip_prefijo + "-" + proceso.pro_prefijo + "-" + code_id.value;
    } else if (op.value == 'edit') {
        return tipoDoc.tip_prefijo + "-" + proceso.pro_prefijo + "-" + form.id;
    }
});


const alert = (msj, icon = "success") => {
    Swal.fire({
        title: msj,
        icon: icon
    })
}

const openModal = (operation, document = "") => {
    modal.value = true;
    op.value = operation;
    if (operation == 'add') {
        modalConfig.value.title = 'Agregar un Nuevo Documento';
        modalConfig.value.buttonTitle = 'Agregar';
    } else if (operation == 'edit') {
        modalConfig.value.title = 'Editar el Documento ' + document.id;
        modalConfig.value.buttonTitle = 'Actualizar';
        form.id = document.id;
        form.codigo = document.codigo;
        form.nombre = document.nombre;
        form.contenido = document.contenido;
        form.proceso_id = document.proceso_id;
        form.tipo_doc_id = document.tipo_doc_id;
    }
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};

const submitForm = () => {
    form.codigo = codigoInput;
    if (op.value == 'add') {
        createDocument();
    } else if (op.value == 'edit') {
        updateDocument();
    }
}

const createDocument = () => {
    form.post(route('documentStore'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Documento Creado Correctamente');
            closeModal();
            form.reset();
        },
        onError: () => {
            alert('Sucedio Un Error', "error");
        }
    });
};

const updateDocument = () => {
    form.put(route('documentUpdate', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Documento Actualizado Correctamente');
            closeModal();
            form.reset()
        },
        onError: () => {
            alert('Sucedio Un Error', "error");
        }
    });
};

const deleteDocument = (id, name) => {
    const alertDelete = Swal.mixin({
        buttonsStyling: true
    });
    alertDelete.fire({
        title: `¿Seguro Quieres Eliminar El Documento ${name}?`,
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> ¡Si, Eliminar!',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((response) => {
        if (response.isConfirmed) {
            formDelete.delete(route('documentDestroy', id), {
                onSuccess: () => {
                    alert('Documento Eliminado Correctamente');
                    closeModal();
                },
                onError: () => {
                    alert('Sucedio Un Error', "error");
                }
            });
        }
    });
}

</script>

<template>
    <Head title="Documentos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Documentos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="row d-flex space-between">
                        <button class="btn btn-success col-3" @click.prevent="openModal('add')">
                            <i class="fa-solid fa-plus"></i> Agregar
                        </button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Codigo</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Contenido</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Proceso</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="document in documents" :key="document.id">
                                <th>{{ document.id }}</th>
                                <th>{{ document.codigo }}</th>
                                <th>{{ document.nombre }}</th>
                                <th>{{ document.contenido }}</th>
                                <th>{{ document.tipo_doc.tip_nombre + " (" + document.tipo_doc.tip_prefijo + ")" }}</th>
                                <th>{{ document.proceso.pro_nombre + " (" + document.proceso.pro_prefijo + ")" }}</th>
                                <td>
                                    <div class="btn-group mr-2" role="group">
                                        <button class="btn btn-info" @click.prevent="openModal('edit', document)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger"
                                            @click="deleteDocument(document.id, document.nombre)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- MODAL DOCUMENT -->
    <Modal :show="modal" @close="closeModal">
        <div class="p-10">
            <h1 class="text-lg font-medium text-gray-900">
                {{ modalConfig.title }}
            </h1>

            <div class=" row mt-6 ml-6 mr-6">
                <input type="hidden" class="form-control" id="identification" aria-describedby="basic-addon3 basic-addon4"
                    v-model="form.id">
                <div class="mb-3 col-6">
                    <label for="nombre" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="nombre" aria-describedby="basic-addon3 basic-addon4"
                        v-model="form.nombre" />
                    <InputError :message="form.errors.nombre" class="mt-2" />
                </div>
                <div class="mb-3 col-6">
                    <label for="codigo" class="form-label">Codigo</label>
                    <input type="text" class="form-control" id="codigo" aria-describedby="basic-addon3 basic-addon4"
                        :value="codigoInput" disabled />
                    <InputError :message="form.errors.codigo" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea class="form-control" aria-label="With textarea" id="contenido"
                        v-model="form.contenido"></textarea>
                    <InputError :message="form.errors.contenido" class="mt-2" />
                </div>

                <div class="mb-3 col-6">
                    <label for="tipo_doc_id" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo_doc_id" v-model="form.tipo_doc_id">
                        <option selected>Selecciona...</option>
                        <option v-for="tipo in tipoDocs" :key="tipo.id" :value="tipo.id">
                            {{ tipo.tip_nombre + " (" + tipo.tip_prefijo + ")" }}
                        </option>
                    </select>
                    <InputError :message="form.errors.tipo_doc_id" class="mt-2" />
                </div>

                <div class="mb-3 col-6">
                    <label for="proceso_id" class="form-label">Proceso</label>
                    <select class="form-select" id="proceso_id" v-model="form.proceso_id">
                        <option selected>Selecciona...</option>
                        <option v-for="proceso in procesos" :key="proceso.id" :value="proceso.id">
                            {{ proceso.pro_nombre + " (" + proceso.pro_prefijo + ")" }}
                        </option>
                    </select>
                    <InputError :message="form.errors.proceso_id" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>
                <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="submitForm">
                    {{ modalConfig.buttonTitle }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>


