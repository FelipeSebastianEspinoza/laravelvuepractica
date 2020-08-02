<template>
    <b-container fluid>
        <!-- Title and add button -->
        <h3>
            Título
            <button
                type="button"
                class="btn btn-primary float-right mb-2"
                data-toggle="modal"
                data-target="#create2"
                @click="limpiarModal"
            >
                Nueva categoríafsdd
            </button>
        </h3>
        <!-- User Interface controls -->
        <b-row>
            <b-col lg="6" class="my-1">
                <b-form-group
                    label="Búsqueda"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    label-for="filterInput"
                    class="mb-0"
                >
                    <b-input-group size="sm">
                        <b-form-input
                            v-model="filter"
                            type="search"
                            id="filterInput"
                            placeholder="Escriba..."
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''"
                                >Limpiar</b-button
                            >
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col lg="6" class="my-1">
                <b-form-group
                    label="Buscar por:"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                >
                    <b-form-checkbox-group v-model="filterOn" class="mt-1">
                        <b-form-checkbox value="name">Nombre</b-form-checkbox>
                        <b-form-checkbox value="description"
                            >Descripción</b-form-checkbox
                        >
                    </b-form-checkbox-group>
                </b-form-group>
            </b-col>

            <b-col v-if="this.categorias.length > 5" sm="5" md="6" class="my-1">
                <b-form-group
                    label="Mostrar"
                    label-cols-sm="6"
                    label-cols-md="4"
                    label-cols-lg="3"
                    label-align-sm="right"
                    label-size="sm"
                    label-for="perPageSelect"
                    class="mb-0"
                >
                    <b-form-select
                        v-model="perPage"
                        id="perPageSelect"
                        size="sm"
                        :options="pageOptions"
                    ></b-form-select>
                </b-form-group>
            </b-col>

            <b-col v-if="this.categorias.length > 5" sm="7" md="6" class="my-1">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="fill"
                    size="sm"
                    class="my-0"
                ></b-pagination>
            </b-col>
        </b-row>

        <!-- Main table element -->
        <b-table
            show-empty
            small
            stacked="md"
            :items="categorias"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            :filterIncludedFields="filterOn"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :sort-direction="sortDirection"
            @filtered="onFiltered"
            :striped="striped"
            :bordered="bordered"
            :hover="hover"
            :dark="dark"
        >
            <template v-slot:cell(actions)="atributos">
                <button
                    class="btn btn-warning btn-sm"
                    @click="editarFormulario(atributos), resetModal()"
                >
                    <svg
                        class="bi bi-pencil-square"
                        width="1.5em"
                        height="1.5em"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"
                        />
                        <path
                            fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"
                        />
                    </svg>
                </button>

                <button
                    class="btn btn-danger btn-sm"
                    @click="eliminarCategoria(atributos)"
                >
                    <svg
                        class="bi bi-trash"
                        width="1.5em"
                        height="1.5em"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                        />
                        <path
                            fill-rule="evenodd"
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                        />
                    </svg>
                </button>
            </template>
        </b-table>
        <b-form-group label="Opciones" label-cols-lg="2">
            <b-form-checkbox v-model="striped" inline
                >Interlineado</b-form-checkbox
            >
            <b-form-checkbox v-model="bordered" inline
                >Cuadricula</b-form-checkbox
            >
            <b-form-checkbox v-model="dark" inline>Oscura</b-form-checkbox>
        </b-form-group>
        <!--Modal edit-->
        <div
            class="modal fade"
            id="edit"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Editar categoría
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="cancelarEdicion"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="editarCategoria(categoria)">
                            <!--   <h3>Editar categoria</h3> -->
                            <h5>Nombre</h5>
                            <input
                                type="text"
                                class="form-control mb-2"
                                placeholder="Escriba un nombre..."
                                v-model="categoria.name"
                                v-bind:class="{
                                    'is-valid': nameValid,
                                    'is-invalid': nameInvalid
                                }"
                            />
                            <p class="text-danger" v-if="nameInvalid">
                                Escriba un nombre válido
                            </p>
                            <h5>Descripción</h5>
                            <input
                                type="text"
                                class="form-control mb-2"
                                placeholder="Escriba una descripción..."
                                v-model="categoria.description"
                                v-bind:class="{
                                    'is-valid': descriptionValid,
                                    'is-invalid': descriptionInvalid
                                }"
                            />
                            <p class="text-danger" v-if="descriptionInvalid">
                                Escriba un texto más extenso
                            </p>
                            <button class="btn btn-warning" type="submit">
                                Editar
                            </button>

                            <button
                                class="btn btn-danger"
                                type="button"
                                @click="cancelarEdicion"
                            >
                                Cancelar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal create-->
        <div
            class="modal fade"
            id="create2"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Añadir categoría
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="agregar">
                            <h5>Nombre:</h5>
                            <input
                                type="text"
                                class="form-control mb-2"
                                placeholder="Escriba un nombre..."
                                v-model="categoria.name"
                                v-bind:class="{
                                    'is-valid': nameValid,
                                    'is-invalid': nameInvalid
                                }"
                            />
                            <p class="text-danger" v-if="nameInvalid">
                                Escriba un nombre válido
                            </p>

                            <h5>Descripción:</h5>

                            <input
                                type="text"
                                class="form-control mb-2"
                                placeholder="Escriba una descripción..."
                                v-model="categoria.description"
                                v-bind:class="{
                                    'is-valid': descriptionValid,
                                    'is-invalid': descriptionInvalid
                                }"
                            />
                            <p class="text-danger" v-if="descriptionInvalid">
                                Escriba un texto más extenso
                            </p>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Cerrar
                                </button>
                                <button class="btn btn-primary" type="submit">
                                    Agregar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            categorias: [],
            categoria: { name: "", description: "" },
            //formato de la tabla
            striped: false,
            bordered: false,
            hover: true,
            dark: false,

            fields: [
                {
                    key: "name",
                    label: "Nombre",
                    sortable: true,
                    tdClass: "tablaAttNombre"
                },
                {
                    key: "description",
                    label: "Descripcion",
                    tdClass: "tablaAttDescripcion"
                },
                {
                    key: "actions",
                    label: "Actions",
                    tdClass: "tablaAttActions"
                }
            ],

            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            pageOptions: [5, 10, 15],
            sortBy: "",
            sortDesc: false,
            sortDirection: "asc",
            filter: null,
            filterOn: [],
            //modals
            nameValid: false,
            nameInvalid: false,
            descriptionValid: false,
            descriptionInvalid: false
        };
    },
    created() {
        axios.get("/categorias").then(res => {
            this.categorias = res.data;
            this.totalRows = this.categorias.length;
        });
    },

    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key };
                });
        }
    },

    methods: {
        agregar() {
            var errors = [];
            if (!this.categoria.name) {
                this.nameValid = false;
                this.nameInvalid = true;
                errors.push("0");
            } else {
                this.nameValid = true;
                this.nameInvalid = false;
            }
            if (!this.categoria.description) {
                this.descriptionValid = false;
                this.descriptionInvalid = true;
                errors.push("0");
                //   } else if (!this.validEmail(this.categoria.description)) {
            } else if (this.categoria.description.length < 5) {
                this.descriptionValid = false;
                this.descriptionInvalid = true;
                errors.push("0");
            } else {
                this.descriptionValid = true;
                this.descriptionInvalid = false;
            }
            if (errors.length) {
                return;
            }

            const categoriaNueva = this.categoria;
            this.categoria = { name: "", description: "" };

            axios.post("/categorias", categoriaNueva).then(res => {
               
                const categoriaServidor = res.data;
                this.categorias.push(categoriaServidor);
               $("#create2").modal("toggle");
               
                $('.modal-backdrop').remove();
            });
        },
        eliminarCategoria(atributos) {
            const confirmacion = confirm(
                `Eliminar categoría ${atributos.item.name}`
            );

            var indexNuevo = atributos.index;

            indexNuevo = indexNuevo + this.perPage * (this.currentPage - 1);

            if (confirmacion) {
                axios.delete(`/categorias/${atributos.item.id}`).then(() => {
                    this.categorias.splice(indexNuevo, 1);
                });
            }
        },
        editarFormulario(atributos) {
            $("#edit").modal("toggle");
            this.categoria.name = atributos.item.name;
            this.categoria.description = atributos.item.description;
            this.categoria.id = atributos.item.id;
        },
        editarCategoria(categoria) {
            const params = {
                name: categoria.name,
                description: categoria.description
            };

            var errors = [];
            if (this.categoria.name.trim() === "") {
                this.nameValid = false;
                this.nameInvalid = true;
                errors.push("0");
            } else {
                this.nameValid = true;
                this.nameInvalid = false;
            }
            if (this.categoria.description.trim() === "") {
                this.descriptionValid = false;
                this.descriptionInvalid = true;
                errors.push("0");
                //   } else if (!this.validEmail(this.categoria.description)) {
            } else if (this.categoria.description.length < 5) {
                this.descriptionValid = false;
                this.descriptionInvalid = true;
                errors.push("0");
            } else {
                this.descriptionValid = true;
                this.descriptionInvalid = false;
            }

            if (errors.length) {
                return;
            }

            axios.put(`/categorias/${categoria.id}`, params).then(res => {
                const index = this.categorias.findIndex(
                    item => item.id === categoria.id
                );
                this.categorias[index] = res.data;
                this.categorias.splice(index, 0); //para recargar los valores ya que se usa modal
            });
            $("#edit").modal("toggle");
        },
        cancelarEdicion() {
            $("#edit").modal("toggle");
            this.categoria = { name: "", description: "" };
        },
        limpiarModal() {
            this.nameValid = false;
            this.nameInvalid = false;
            this.descriptionValid = false;
            this.descriptionInvalid = false;
            this.categoria = { name: "", description: "" };
        },
        resetModal() {
            this.nameValid = false;
            this.nameInvalid = false;
            this.descriptionValid = false;
            this.descriptionInvalid = false;
        },
        validEmail: function(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        }
    }
};
</script>

<style>
.tablaAttNombre {
    max-width: 300px;
}
.tablaAttDescripcion {
    max-width: 400px;
}
.tablaAttActions {
    max-width: 300px;
}
</style>
