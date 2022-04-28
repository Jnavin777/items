<template>
        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card-box text-center">
                    <img src="/assets/images/users/avatar-1.gif" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">

                    <h4 class="mb-0">{{ user.name }}</h4>
                    <p class="text-muted">{{ user.email }}</p>
                    <span v-for="role in user.roles" :key="role.id">
                        <b-badge variant="info">{{ role.name}}</b-badge>
                    </span>
                </div> <!-- end card-box -->

                <div class="card-box text-center">
                    <img src="/assets/images/users/users.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    <template v-if="user.owned_teams.length > 0">
                        <h4 class="mb-0">Owned Teams</h4>
                        <span v-for="ownedTeam in user.owned_teams" :key="ownedTeam.id">
                        <b-badge variant="warning">{{ ownedTeam.name}}</b-badge>
                    </span>
                    </template>
                    <h4 class="mb-0">Teams</h4>
                    <span v-for="team in user.teams" :key="team.id">
                        <b-badge variant="success">{{ team.name}}</b-badge>
                    </span>
                </div> <!-- end card-box -->

            </div> <!-- end col-->

            <div class="col-lg-8 col-xl-8">
                <div class="card-box">

                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                    <b-row>
                        <b-col cols="6">
                            <b-form-group
                                label="Name"
                                label-for="name-input">
                                <b-form-input id="name" v-model="user.name" required></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row> <!-- end row -->

                    <b-row>
                        <b-col cols="6">
                            <b-form-group
                                label="Email"
                                label-for="email-input">
                                <b-form-input id="email" v-model="user.email" required></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col cols="6">
                            <b-form-group
                                label="Password"
                                label-for="password-input">
                                <b-form-input type="password" id="password" v-model="user.password" required></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row> <!-- end row -->
                    <div class="text-right">
                        <button @click="onSubmit" class="btn btn-success waves-effect waves-light mt-2">
                            <i class="mdi mdi-content-save"></i> Save
                        </button>
                    </div>
                    <!-- end settings content-->
                </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>

</template>

<script>
export default {
    name: "MyProfile",
    props: ['user'],
    methods: {
        onSubmit() {
            console.log(this.user);
            axios.post('/profile/update/', this.user)
                .then((response)=>{
                    window.location.reload()
                });
        }
    }
}
</script>
