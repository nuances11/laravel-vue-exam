<template>
    <div>
        <div class="container-fluid page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h4>Users</h4>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6 col-lg-9 col-md-9 col-sm-6">
                                    <form class="d-flex my-1 search-bar" @submit.prevent="getAllUsers">
                                        <div class="input-group">
                                            <input class="form-control" type="search" v-model="search" placeholder="Search"
                                                aria-label="Search" />
                                            <button class="btn btn-secondary" type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-6 col-md-3 col-sm-6 my-1 text-end">
                                    <div data-app>
                                        <user-add-modal @onSubmitSuccess="getAllUsers()"></user-add-modal>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <v-data-table :headers="headers" :items="users" :items-per-page="10" loading
                                loading-text="Loading... Please wait" class="elevation-2">
                                <template v-slot:body="{items, headers}">
                                    <tbody name="list" is="transition-group" v-if="items.length > 0">
                                        <tr v-for="item in items" :key="item.id" class="item-row">
                                        <td>{{item.id}}</td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.email}}</td>
                                        <td>
                                            <div data-app>
                                                <user-update-modal @onSubmitSuccess="getAllUsers()" :userId="item.id"></user-update-modal>
                                        <user-delete-modal @onSubmitSuccess="getAllUsers()" :userId="item.id"></user-delete-modal>
                                            </div>
                                        </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                        <td :colspan="headers.length" style="text-align: center">No data available.</td>
                                        </tr>
                                    </tbody>
                                </template>
                                <!-- <template v-slot:item.action="{ item }">
                                    <div data-app>
                                        <user-update-modal @onSubmitSuccess="getAllUsers()" :userId="item.id"></user-update-modal>
                                        <user-delete-modal @onSubmitSuccess="getAllUsers()" :userId="item.id"></user-delete-modal>
                                    </div>
                                </template> -->
                            </v-data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UserAddModal from './includes/UserAddModal.vue';
    import UserUpdateModal from './includes/UserUpdateModal.vue';
    import UserDeleteModal from './includes/UserDeleteModal.vue';

    export default {
        components: {
            UserAddModal,
            UserUpdateModal,
            UserDeleteModal
        },
        data() {
            return {
                headers: [{
                        text: '#',
                        align: 'middle',
                        value: 'id',
                    },
                    {
                        text: 'NAME',
                        value: 'name'
                    },
                    {
                        text: 'EMAIL',
                        value: 'email'
                    },
                    {
                        text: 'ACTIONS',
                        value: 'action'
                    }
                ],
                users: [],
                user: {},
                alertMessage: '',
                success: false,
                errors: [],
                isEditing: false,
                search: ''
            }
        },
        created() {
            this.getAllUsers();
        },
        methods: {
            getAllUsers() {
                this.axios
                    .get(`${this.apiUrl}users`, { params: { keyword: this.search } })
                    .then(response => {
                        this.users = response.data;
                    });
            }

        }
    }

</script>
