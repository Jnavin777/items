<template>
    <div>
        <b-table hover
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
                <b-button variant="success" size="sm" @click="acceptInvite(row.item)" class="mr-1">
                    Accept
                </b-button>
                <b-button variant="warning" size="sm" @click="rejectInvite(row.item)" class="mr-1">
                    Reject
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "InvitesTable",
    data() {
        return {
            currentPage: 1,
            isBusy: false,
            perPage: 25,
            items: [],
            fields: [
                {key:'id', label: 'ID'},
                {key:'team.name', label: 'Team name'},
                {key:'inviter.name', label: 'Inviter'},
                {key:'actions', label: 'Actions'},
            ]
        }
    },
    asyncComputed: {
        getInvites() {
            let self = this;
            this.isBusy = true;
            axios.get(window.routes.my_invites)
                .then((response)=>{
                    this.items = response.data;
                    this.isBusy = false;
                })
        }
    },
    methods: {
        acceptInvite(invite) {
        axios.get('/teams/accept/'+invite.accept_token)
            .then((response)=>{
                this.items = response.data;
                this.isBusy = false;
            })
        },
        rejectInvite(invite) {

        }
    }
}
</script>
