<template>
    <div>
        <b-row>
            <b-col cols="2">
                <b-button variant="success" @click="createItem">Add new role</b-button>
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
                <template #cell(actions)="row">
<!--                    <b-button variant="info" size="sm" :href="'admin/role/'+row.item.id" class="mr-1">-->
<!--                        <b-icon icon="eye"></b-icon>-->
<!--                    </b-button>-->
                    <b-button variant="warning" size="sm" @click="onEdit(row.item)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button variant="danger" size="sm" @click="confirmDelete(row.item)">
                        Delete
                    </b-button>
                </template>
            </b-table>
        </div>
        <create-update-role-modal
            :action="actionModal"
            :role="role"
            @updateRole="getItems"
            @resetRoleModal="resetRoleModal">
        </create-update-role-modal>
    </div>
</template>

<script>
export default {
    name: "AdminRoleIndex",
    data() {
        return {
            actionModal: 'CREATE',
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            role: {
                name: null,
            },
            isBusy: false,
            currentPage: 1,
            perPage: 25,
            items: [],
            fields: [
                {key:'id'},
                {key:'name'},
                {key:'actions'},
            ]
        }
    },
    methods: {
        resetRoleModal() {
            this.role = {
                name: null,
                permissions: [],
                id: null
            }
        },
        createItem() {
            this.actionModal = this.CREATE;
            this.resetRoleModal();
            this.$bvModal.show('modal-role');
        },
        onEdit(item) {
            this.actionModal = this.UPDATE;
            this.role.name = item.name;
            this.role.permissions = item.permissions.map(item => item.id);
            this.role.id = item.id;
            this.$bvModal.show('modal-role');
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
            axios.delete('/admin/role/'+item.id)
                .then((response)=>{
                    this.getItems();
                })
        },
        getItems() {
            this.isBusy = true;
            axios.get(window.routes.role_get_items)
                .then(({data: response})=>{
                    this.items = response
                    this.isBusy = false;
                })
        }
    },
    created() {
        this.getItems();
    }
}
</script>


