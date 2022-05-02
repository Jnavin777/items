<template>
    <b-modal
        id="modal-user"
        ref="modal"
        :title="action === CREATE ? 'Create user' : 'Update user #'+user.id"
        @hidden="resetModal"
        @ok="handleOk"
    >
        <form ref="form" @submit.stop.prevent="handleSubmit">
            <b-form-group
                label="Name"
                label-for="name-input">
                <b-form-input
                    id="name-input"
                    v-model="user.name"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label="Email"
                label-for="email-input">
                <b-form-input
                    id="email-input"
                    v-model="user.email"
                    autocomplete="off"
                    value=""
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label="Password"
                label-for="password-input">
                <b-form-input
                    id="password-input"
                    type="text"
                    v-model="user.password"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label="Role"
                label-for="role-input">
                <b-form-select v-model="user.role" :options="roleOptions">
                    <template #first>
                        <b-form-select-option :value="null" disabled>-- Please select an option --</b-form-select-option>
                    </template>
                </b-form-select>
            </b-form-group>
        </form>
    </b-modal>
</template>

<script>
export default {
    name: "CreateUpdateUserModal",
    props: ['action', 'user'],
    data() {
        return {
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            roleOptions: []
        }
    },
    asyncComputed: {
        getRoles() {
            let self = this;
            return axios.get('/get-filter/role')
                .then((response) => {
                    self.roleOptions = response.data.data;
                })
        }
    },
    methods: {
        handleOk() {
            let self = this;
            if(this.action === this.CREATE) {
                axios.post(window.routes.user_store, this.user)
                    .then((response)=>{
                        self.$emit('updateUser')
                    });
            } else if(this.action === this.UPDATE) {
                axios.put('/admin/user/'+this.user.id, this.user)
                    .then((response)=>{
                        self.$emit('updateUser')
                    })
            }
        },
        resetModal(){
            this.$emit('resetUserModal')
        }
    },
    created() {
        this.resetModal();
    }
}
</script>
