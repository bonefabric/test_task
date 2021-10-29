<template>
	<div>

		<table class="table" v-if="isUsersLoaded">
			<thead>
			<tr>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Created at</th>
				<th scope="col">Updated at</th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="user in users" :key="user.id">
				<td><router-link :to="{name: 'user', params: {id: user.id}}">{{ user.name }}</router-link></td>
				<td>{{ user.email }}</td>
				<td>{{ (new Date(user.created_at)).toLocaleString() }}</td>
				<td>{{ (new Date(user.updated_at)).toLocaleString() }}</td>
			</tr>
			</tbody>
		</table>

		<div v-else>
			Loading...
		</div>

	</div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
	name: "index",
	mounted() {
		this.$store.dispatch('loadUsers').catch(() => {
		});
	},
	computed: {
		...mapGetters([
			'users',
			'isUsersLoaded',
		]),
	}
}
</script>

<style scoped>

</style>
