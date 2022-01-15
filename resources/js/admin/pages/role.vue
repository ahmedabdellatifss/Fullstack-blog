<template>
    <div>
        <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Management <Button @click="addModal=true"><Icon type="md-add" />Add Role</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Role Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role, i) in roles" :key="i" v-if="roles.length">
								<td>{{role.id}}</td>
								<td class="_table_name">{{role.roleName}}</td>
								<td>{{role.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(role, i)" >Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(role, i)"  :loading="role.isDeleting" >Delete</Button>

								</td>
							</tr>
								<!-- ITEMS -->
					</table>
					</div>
				</div>


				<!-- tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add Role"
					:mask-closable="false"
					:closable="false"

					>
					<Input v-model="data.roleName" placeholder=" Role Name"  />

					<div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add role'}}</Button>
					</div>

				</Modal>
				<!-- tag Editing modal -->
				<Modal
					v-model="editModal"
					title="Edit role"
					:mask-closable="false"
					:closable="false"

					>
					<Input v-model="editData.roleName" placeholder="Edit Role name"  />

					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Role'}}</Button>
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
				roleName: ''
			},
			addModal : false,
			editModal : false,
			isAdding : false,
			roles : [],
            editData: {
                roleName:''
            },
            index : -1,
            showDeleteModal: false,
			isDeleting : false,
			deleteItem: {},
			deletingIndex: -1,
			websiteSettings: []
        }
    },
    methods: {
        async add(){
            if(this.data.roleName.trim() == '') return this.e('Role name is required')
            const res = await this.callApi('post' , 'app/create_role' , this.data);
            if(res.status == 201) {
                this.roles.unshift(res.data)
                this.s('roleName has been added successfuly!')
                this.addModal = false
                this.data.roleName = ''
            }else{
                if(res.status == 422) {
                    if (res.data.errors.roleName)
                        this.e(res.data.errors.roleName[0])
                }else{
                    this.swr()
                }
            }
        },
        async edit(){
            if(this.editData.roleName.trim() == '') return this.e('Role name is required')
            const res = await this.callApi('post' , 'app/edit_role' , this.editData);
            if(res.status == 200) {
                this.roles[this.index].roleName = this.editData.roleName
                this.s('Role namr has been edit successfuly!')
                this.editModal = false
            }else{
                if(res.status == 422) {
                    if (res.data.errors.roleName)
                        this.e(res.data.errors.roleName[0])
                }else{
                    this.swr()
                }
            }
        },
        showEditModal(role , index){
            let obj = {
				id : role.id,
				roleName : role.roleName
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
		const res = await this.callApi('get', 'app/get_roles')
		if(res.status==200){
			this.roles = res.data
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
