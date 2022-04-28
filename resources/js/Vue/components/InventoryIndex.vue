<template>
    <div>
        <b-row>
            <b-col cols="2">
                <b-button variant="success" v-b-modal.modal-inventory>Add new inventory</b-button>
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
                    <b-button variant="info" size="sm" :href="'inventory/'+row.item.id" class="mr-1">
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
        <create-update-inventory-modal
            :action="actionModal"
            :inventory="inventory"
            @updateInventory="getItems"
        @resetInventoryModal="resetInventoryModal">
        </create-update-inventory-modal>
    </div>
</template>

<script>
export default {
    name: "InventoryIndex",
    props: ['branches'],
    data() {
        return {
            actionModal: 'CREATE',
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            isBusy: false,
            currentPage: 1,
            perPage: 25,
            inventory: {
                name: null,
                description: null,
                branch: null
            },
            items: [],
            fields: [
                {key:'id', label:'ID'},
                {key:'name', label: 'Name'},
                {key:'description', label: 'Description'},
                {key:'branch.name', label: 'Branch'},
                {key:'totalItems', label: 'Items'},
                {key:'actions', label: 'Actions'},
            ]
        }
    },
    methods: {
        resetInventoryModal() {
            this.inventory = {
                name: null,
                description: null,
                branch: null
            }
        },
        confirmDelete(item) {
            let confirmMessage = item.totalItems
                ? 'Are you sure? This Inventory has '+item.totalItems+' items'
                : 'Are you sure?'
            this.$bvModal.msgBoxConfirm(confirmMessage)
                .then(value => {
                    if(value) {
                        this.onDelete(item)
                    }
                });
        },
        onEdit(item) {
            this.actionModal = this.UPDATE;
            this.inventory.id = item.id;
            this.inventory.name = item.name;
            this.inventory.description = item.description;
            this.inventory.branch_id = item.branch_id;
            this.$bvModal.show('modal-inventory');
        },
        onDelete(item) {
            axios.delete('inventory/'+item.id)
                .then((response)=>{
                    this.getItems();
                })
        },
        getItems() {
            this.isBusy = true;
            axios.get(window.routes.inventory_get_items)
                .then(({data: response})=>{
                    this.items = response.map(item => {
                        item.inventory.totalItems = item.totalItems
                        return item.inventory
                    });
                    this.isBusy = false;
                })
        },
    },
    created() {
        this.getItems();
    }
}
</script>


