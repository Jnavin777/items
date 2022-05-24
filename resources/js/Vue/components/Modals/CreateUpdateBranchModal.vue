<template>
    <b-modal
        id="modal-branch"
        ref="modal"
        :title="action === CREATE ? 'Create branch' : 'Update branch #'+branch.id"
        @hidden="resetModal"
        @ok="handleOk"
    >
        <form ref="form" @submit.stop.prevent="handleSubmit">
            <b-form-group
                label="Name"
                label-for="name-input"
                invalid-feedback="Name is required"
                :state="nameState"
            >
                <b-form-input
                    id="name-input"
                    v-model="branch.name"
                    :state="nameState"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group
                    label="Resp user"
                    label-for="resp-user-input">
                <b-form-select v-model="branch.resp_user_id" :options="respUserOptions">
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
    name: "CreateUpdateBranchModal",
    props: ['action', 'branch'],
    data() {
        return {
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            modal: {
                action: null,
                title: null,
                resp_user_id: null,
                editItemId: null
            },
            nameState: null,
            respUserOptions: []
        }
    },
    asyncComputed: {
        getRespUsers() {
            let self = this;
            return axios.get('/get-filter/ownedTeamsUsers')
                .then((response)=>{
                    self.respUserOptions = response.data.data;
                })
        }
    },
    methods: {
        handleOk() {
            let self = this;
            if(!this.validate()) {
                return false;
            }
            if(this.action === this.CREATE) {
                axios.post(window.routes.branch_store, this.branch)
                    .then((response)=>{
                        self.$emit('updateBranch')
                    });
            } else if(this.action === this.UPDATE) {
                axios.patch('/branch/'+this.branch.id, this.branch)
                    .then((response)=>{
                        self.$emit('updateBranch')
                    })
            }
        },
        resetModal(){
            this.$emit('resetBranchModal')
        },
        validate() {
            let result = true;
            return result
        }
    },
    created() {
        this.resetModal();
    }
}
</script>

<style scoped>

</style>
