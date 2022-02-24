<template>
    <v-dialog v-model="dialog" persistent max-width="290">
        <template v-slot:activator="{ on, attrs }">
            <button class="btn btn-action" @click="checkUserData(userId)" v-bind="attrs" v-on="on">
                    <i class="bi bi-trash"></i>
            </button>
        </template>
        <v-card>
            <v-card-title class="text-h5">
                {{ dialogHeader }}
            </v-card-title>
            <v-card-text>
                {{ dialogBody }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false">
                    Cancel
                </v-btn>
                <v-btn color="red darken-1" v-if="canDelete" text @click="deleteUser(userId)">
                    Agree
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: ['userId'],
        data () {
            return {
                dialog: false,
                users: [],
                dialogHeader: '',
                dialogBody: '',
                canDelete: false,
            }
        },
        methods: {
            checkUserData(id) {
                this.axios
                    .get(`${this.apiUrl}users/${id}`)
                    .then(response => {
                        if(response.data.albums.length) {
                            console.log('Has existing albums');
                            this.canDelete = false;
                            this.dialogHeader = 'Action failed';
                            this.dialogBody = 'Can\'t delete users with existing albums.';
                        }else{
                            this.canDelete = true;
                            this.dialogHeader = 'Are you sure?';
                            this.dialogBody = 'Data will be deleted permanently.';
                        }
                });
            },
            deleteUser(id) {
                this.axios
                    .delete(`${this.apiUrl}users/${id}`)
                    .then(response => {
                        this.getAllUsers();
                        let i = this.users.map(user => user.id).indexOf(id); // find index of your object
                        this.users.splice(i, 1)
                        this.$emit('onSubmitSuccess');
                        this.dialog = false;
                    });

            },
            getAllUsers() {
                this.axios
                    .get(`${this.apiUrl}users`)
                    .then(response => {
                        this.users = response.data;
                    });
            }

        }
    }

</script>
