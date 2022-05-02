<template>
    <div>
        <b-row>
            <b-col cols="2">
                <b-button v-if="isAddNewBranch" variant="success" @click="createBranch">Add new branch</b-button>
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
                    <b-button variant="info" size="sm" :href="'branch/'+row.item.id" class="mr-1">
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
        <create-update-branch-modal
            :action="actionModal"
            :branch="branch"
            @updateBranch="getItems"
            @resetBranchModal="resetBranchModal">
        </create-update-branch-modal>
    </div>
</template>

<script>
export default {
    name: "BranchIndex",
    props: ['isAddNewBranch'],
    data() {
        return {
            actionModal: 'CREATE',
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            branch: {
                name: null,
                resp_user_id: null,
                id: null
            },
            isBusy: false,
            currentPage: 1,
            nameState: null,
            perPage: 25,
            items: [],
            fields: [
                {key:'id'},
                {key:'name'},
                {key:'resp_user.name', label: 'Responsible user'},
                {key:'totalItems', label: 'Inventories'},
                {key:'actions'},
            ]
        }
    },
    methods: {
        resetBranchModal() {
            this.branch = {
                name: null,
                resp_user_id: null,
                id: null
            }
        },
        createBranch() {
            this.actionModal = this.CREATE;
            this.resetBranchModal();
            this.$bvModal.show('modal-branch');
        },
        onEdit(item) {
            this.actionModal = this.UPDATE;
            this.branch.name = item.name;
            this.branch.id = item.id;
            this.branch.resp_user_id = item.resp_user_id;
            this.$bvModal.show('modal-branch');
        },
        confirmDelete(item) {
            let confirmMessage = item.totalItems
                ? 'Are you sure? This Branch has '+item.totalItems+' inventories'
                : 'Are you sure?'
            this.$bvModal.msgBoxConfirm(confirmMessage)
                .then(value => {
                    if(value) {
                        this.onDelete(item)
                    }
                });
        },
        onDelete(item) {
            axios.delete('branch/'+item.id)
                .then((response)=>{
                    this.getItems();
                })
        },
        getItems() {
            this.isBusy = true;
            axios.get(window.routes.branch_get_items)
                .then(({data: response})=>{
                    this.items = response.map(item => {
                        item.branch.totalItems = item.totalItems
                        return item.branch
                    });
                    this.isBusy = false;
                })
        }
    },
    created() {
        this.getItems();
    }
}
</script>


