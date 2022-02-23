<template>
    <div class="text-md-end text-sm-start">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on, attrs }">
                <!-- <button class="btn btn-action" v-bind="attrs" v-on="on">
                    Add User
                </button> -->
                <v-btn
                    class="ma-2 btn-action"
                    v-bind="attrs"
                    v-on="on"
                >
                    Add User
                </v-btn>
            </template>

            <v-card>
                <form @submit.prevent="addUser" class="pb-2 mb-3">
                    <v-card-title class="text-h5 grey lighten-2">
                        Add User
                    </v-card-title>

                    <v-card-text>

                        <div v-if="errors.length" class="alert alert-danger" role="alert">
                            <ul>
                                <li v-for="error in errors" :key="error.id">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="alert alert-success" v-if="success" role="alert">
                            {{  alertMessage }}
                            </div>

                        <v-text-field
                            label="Name*"
                            v-model="user.name"
                            required
                        ></v-text-field>

                        <v-text-field
                            required
                            label="Email*"
                            type="email"
                            v-model="user.email"
                        ></v-text-field>

                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn class="ma-2 btn-action" type="submit" text>
                            Add User
                        </v-btn>
                        <v-btn color="primary" text @click="closeModal(), clearForm()">
                            Cancel
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
        user: {},
        alertMessage: '',
        success: false,
        errors: [],
        isEditing: false,
      }
    },
    methods: {
        closeModal() {
            this.dialog = false;
        },
        addUser() {
            this.errors = [];
            this.success = false;
            this.axios
                .post(`${this.apiUrl}users`, this.user)
                .then((response) => {
                    this.success = response.data.success;
                    this.alertMessage = response.data.message;
                    this.$emit('onSubmitSuccess');
                    this.user = {};
                })
                .catch((error) => {
                    let err = JSON.parse(JSON.stringify(error.response.data.errors));
                    for (var prop in err) {
                        if ( err.hasOwnProperty(prop) ) {
                            this.errors.push(err[prop][0]);
                        }
                    }
                })
        },
        clearForm() {
            this.errors = [];
            this.success = false;
            this.user = {};
        }
    }

  }
</script>
