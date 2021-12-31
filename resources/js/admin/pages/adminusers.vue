<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add" />Add Admin</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>User type</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

								<!-- ITEMS -->
							<tr v-for="(user, i) in users" :key="i" v-if="users.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.fullName}}</td>
								<td class="">{{user.email}}</td>
								<td class="">{{user.userType}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(user, i)"  :loading="user.isDeleting">Delete</Button>

								</td>
							</tr>
								<!-- ITEMS -->
					</table>
					</div>
				</div>


				<!-- tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add admin"
					:mask-closable="false"
					:closable="false"
					>
					<div class="space">
                        <Input type="text" v-model="data.fullName" placeholder="Full name"  />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Email"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Password"  />
                    </div>
                    <div class="space">
                        <Select v-model="data.role_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>

                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
					<div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add admin'}}</Button>
					</div>

				</Modal>


				<!-- tag Editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Admin"
					:mask-closable="false"
					:closable="false"
					>
                    <div class="space">
                        <Input type="text" v-model="editData.fullName" placeholder="Full name"  />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="editData.email" placeholder="Email"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" placeholder="Password"  />
                    </div>
                    <div class="space">
                        <Select v-model="data.role_id"  placeholder="Select admin type">
                            <Option value="Admin" >Admin</Option>
                            <Option value="Editor" >Editor</Option>
                        </Select>
                    </div>
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit admin'}}</Button>
					</div>

				</Modal>
                <!-- delete alert modal -->
				<!-- <Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete tag?.</p>

					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag" >Delete</Button>
					</div>
				</Modal> -->
                <deleteModal></deleteModal>
			</div>
		</div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue'
import { mapGetters } from 'vuex'
export default {
	data(){
        return {
            data : {
                fullName: '',
				email: '',
                password: '',
                role_id: null
			},
			addModal : false,
			editModal : false,
			isAdding : false,
			users : [],
            editData: {
                tagName:''
            },
            index : -1,
            showDeleteModal: false,
			isDeleting : false,
			deleteItem: {},
			deletingIndex: -1,
			websiteSettings: [],
            roles: []
        }
    },
    methods: {
        async addAdmin(){
            if(this.data.fullName.trim() == '') return this.e('Full name is required')
            if(this.data.email.trim() == '') return this.e('email  is required')
            if(this.data.password.trim() == '') return this.e('Password is required')
            if(!this.data.role_id) return this.e('Role id is required')

            const res = await this.callApi('post' , 'app/create_user' , this.data);
            if(res.status == 201) {
                this.users.unshift(res.data)
                this.s('Admin user has been added successfuly!')
                this.addModal = false
                this.data.fullName = ''
            }else{
                if(res.status == 422) {
                    for ( let err in res.data.errors)
                        this.e(res.data.errors[err][0])
                }else{
                    this.swr()
                }

            }
        },
        async editAdmin(){
            if(this.editData.fullName.trim() == '') return this.e('Full name is required')
            if(this.editData.email.trim() == '') return this.e('email  is required')
            if(!this.editData.role_id) return this.e('Role id  is required')
            const res = await this.callApi('post' , 'app/edit_user' , this.editData);
            if(res.status == 200) {
                this.users[this.index] = this.editData
				this.s('User has been edited successfully!')
				this.editModal = false
            }else{
                if(res.status == 422) {
                    for ( let err in res.data.errors)
                        this.e(res.data.errors[err][0])

                }else{
                    this.swr()
                }

            }
        },
        showEditModal(user, index){
			let obj = {
				id : user.id,
				fullName : user.fullName,
				email : user.email,
				userType : user.userType,
			}
			this.editData = obj
			this.editModal = true
			this.index = index
        },
        async deleteTag(){
			this.isDeleting = true
			const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
			if(res.status===200){
				this.tags.splice(this.deletingIndex,1)
				this.s('Tag has been deleted successfully!')
			}else{
				this.swr()
			}
			this.isDeleting = false
			this.showDeleteModal = false

		},
		showDeletingModal(category, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_tag",
                data: category,
                deletingIndex: i,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            // this.deleteItem = category
            // this.deletingIndex = i
            // this.showDeleteModal = true
            },
    },
    async created(){
		const [res, resRole] = await Promise.all([
			this.callApi('get', 'app/get_users'),
			this.callApi('get', 'app/get_roles')
		])
		if(res.status==200){
			this.users = res.data
		}else{
			this.swr()
		}
		if(resRole.status==200){
			this.roles = resRole.data
		}else{
			this.swr()
		}
	},
    components : {
		deleteModal
	},
    computed : {
		...mapGetters(['getDeleteModalObj'])
	},
	watch : {
		getDeleteModalObj(obj){
			if(obj.isDeleted){
				this.tags.splice(obj.deletingIndex,1)
			}
		}
	}

}
</script>

