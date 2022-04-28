<template>
    <div>
<!--        <simple-table :inventories="inventories" :fields="fields"></simple-table>-->
            <b-row>
                <b-col cols="3">
                    <b-button variant="warning" @click="editInventory">Edit inventory</b-button>
                    <b-button variant="success" v-b-modal.modal-item>Add new item</b-button>
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
            <b-table striped hover
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
                    <b-button variant="warning" size="sm" @click="onEditItem(row.item)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button variant="danger" size="sm" @click="onDeleteItem(row.item)">
                        Delete
                    </b-button>
                </template>
            </b-table>
        </div>
        <create-update-inventory-modal
            :action="actionModal"
            :inventory="inventory"
            @updateInventory="getItems">
        </create-update-inventory-modal>
        <create-update-item-modal
            :action="actionItemModal"
            :item="item"
            @updateItem="getItems">
        </create-update-item-modal>
    </div>
</template>

<script>
export default {
    name: "InventoryShow",
    props: ['inventory','conditions','categories'],
    data() {
        return {
            actionModal: 'UPDATE',
            actionItemModal: 'CREATE',
            isBusy: false,
            currentPage: 1,
            perPage: 25,
            item: {
                name: null,
                condition: null,
                article: null,
                categoryId: null,
                dateOfReceiving: null,
                inventoryId: this.inventory.id
            },
            CREATE: 'CREATE',
            UPDATE: 'UPDATE',
            items: [],
            fields: [
                {key:'id', label:'ID'},
                {key:'name', label:'Name'},
                {key:'condition', label:'Condition'},
                {key:'article', label:'Article'},
                {key:'category.name', label:'Category'},
                {key:'date_of_receiving', label:'Date of receiving'},
                {key:'actions', label:'Actions'},
            ]
        }
    },
    methods: {
        updatedInventory() {
            window.location.reload()
        },
        editInventory() {
            this.$bvModal.show('modal-inventory');
        },
        onEditItem(item) {
            this.item.id = item.id;
            this.item.name = item.name;
            this.item.condition = item.condition;
            this.item.article = item.article;
            this.item.categoryId = item.category_id;
            this.item.dateOfReceiving = item.date_of_receiving;

            this.actionItemModal = this.UPDATE;
            this.$bvModal.show('modal-item');

        },
        onDeleteItem(item) {
            axios.delete('item/'+item.id)
                .then((response)=>{
                    this.getItems();
                })
        },
        getItems() {
            this.isBusy = true;
            axios.get('/inventory/'+ this.inventory.id +'/items')
                .then((response)=>{
                    this.items = response.data.items;
                    this.isBusy = false;
                })
        },
        resetModal(){
            this.form = {
                name: null,
                condition: null,
                article: null,
                categoryId: null,
                dateOfReceiving: null,
            }
        },
    },
    created() {
        this.getItems();
        this.resetModal();
    }
}
</script>


