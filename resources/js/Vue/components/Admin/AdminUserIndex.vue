<template>
    <div>
        <b-row>
            <b-col cols="2">
                <b-button variant="success" @click="createUser">Add new user</b-button>
            </b-col>
            <b-col cols="10">
                <b-pagination
                    align="right"
                    v-model="currentPage"
                    :total-rows="items.length"
                    :per-page="perPage"
                    aria-controls="my-table"
                ></b-pagination>
            </b-col>
        </b-row>
        <div class="overflow-auto">
            <b-table hover
                     :busy="isBusy"
                     id="my-table"
                     :items="items"
                     :fields="fields"
                     :per-page="perPage"
                     :current-page="currentPage"
                     small>
                <template #table-busy>
                    <div class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template #cell(roles)="row">
                    <span v-for="role in row.item.roles" :key="role.id">
                        <b-badge variant="info">{{ role.name}}</b-badge>
                    </span>
                </template>
                <template #cell(actions)="row">
                    <b-button variant="info" size="sm" :href="'admin/user/'+row.item.id" class="mr-1">
                        <b-icon icon="eye"></b-icon>
                    </b-button>
                    <b-button variant="warning" size="sm" @click="onEdit(row.item)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button variant="danger" size="sm" @click="confirmDelete(row.item)">
                        Delete
                    </b-button>
                </template>
            </b-table>
        </div>
        <create-update-user-modal
            :action="actionModal"
            :user="user"
            @updateUser="getItems"
            @resetUserModal="resetUserModal">
        </create-update-user-modal>
    </div>
</template>

<script>
export default {
    name: "AdminUserIndex",
    data() {
        return {
            actionModal: 'CREATE',
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            user: {
                name: null,
                email: null,
                password: null,
                roles: [],
                id: null,
                activeTill: null
            },
            isBusy: false,
            currentPage: 1,
            perPage: 25,
            items: [],
            fields: [
                {key:'id'},
                {key:'name'},
                {key:'email'},
                {key:'roles'},
                {key:'details.client_active_till', label: 'Active till'},
                {key:'actions'},
            ]
        }
    },
    methods: {
        resetUserModal() {
            this.user = {
                name: null,
                email: null,
                password: null,
                role: null,
                id: null,
                activeTill: null
            }
        },
        createUser() {
            this.actionModal = this.CREATE;
            this.resetUserModal();
            this.$bvModal.show('modal-user');
        },
        onEdit(item) {
            this.actionModal = this.UPDATE;
            this.user.name = item.name;
            this.user.email = item.email;
            this.user.password = null;
            this.user.role = item.roles.length > 0 ? item.roles[0].id : null;
            this.user.id = item.id;
            this.user.activeTill =
                item.details && item.details.client_active_till
                    ? item.details.client_active_till
                    : null;
            this.$bvModal.show('modal-user');
        },
        confirmDelete(item) {
            let confirmMessage = 'Are you sure?'
            this.$bvModal.msgBoxConfirm(confirmMessage)
                .then(value => {
                    if(value) {
                        this.onDelete(item)
                    }
                });
        },
        onDelete(item) {
            axios.delete('/admin/user/'+item.id)
                .then((response)=>{
                    this.getItems();
                })
        },
        getItems() {
            this.isBusy = true;
            axios.get(window.routes.user_get_items)
                .then(({data: response})=>{
                    this.items = response;
                    this.isBusy = false;
                })
        }
    },
    created() {
        this.getItems();
    }
}
</script>


