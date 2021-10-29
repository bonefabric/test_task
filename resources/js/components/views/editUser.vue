<template>
	<div>
		<form class="mt-5" @submit.prevent>

			<div class="mb-3">
				<label for="inputName" class="form-label">Name</label>
				<input type="text" class="form-control" id="inputName" v-model="name" :disabled="loading">
			</div>
			<button type="submit" class="btn btn-primary" :disabled="loading" @click="saveName">Save</button>
		</form>
		<div class="alert alert-danger mt-3" role="alert" v-if="nameError">
			Error!
		</div>
		<hr>
		<form class="mt-5" @submit.prevent>

			<div class="mb-3">
				<label for="inputPassword" class="form-label">Password</label>
				<input type="password" class="form-control" id="inputPassword" :disabled="loading" v-model="password">
			</div>

			<div class="mb-3">
				<label for="confirmPassword" class="form-label">Confirm password</label>
				<input type="password" class="form-control" id="confirmPassword" :disabled="loading" v-model="passwordConfirmation">
			</div>

			<button type="submit" class="btn btn-primary" :disabled="loading" @click="savePassword">Save</button>
			<div class="alert alert-danger mt-3" role="alert" v-if="passwordError">
				Error!
			</div>
		</form>
	</div>

</template>

<script>
export default {
	name: "editUser",
	data() {
		return {
			name: '',
			password: '',
			passwordConfirmation: '',
			loading: false,
			nameError: false,
			passwordError: false,
		}
	},
	mounted() {
		this.name = this.$store.getters.users.find(user => user.id === this.$route.params.id).name;
	},
	methods: {
		saveName() {
			this.loading = true;
			this.nameError = false;
			this.$store.dispatch('updateName', {id: this.$route.params.id, name: this.name})
				.then(() => {
					this.$router.push({name: 'index'});
				})
				.catch(() => {
					this.nameError = true;
				})
				.finally(() => {
					this.loading = false;
				});
		},
		savePassword() {
			this.loading = true;
			this.passwordError = false;
			if (this.password !== this.passwordConfirmation) {
				this.passwordError = true;
				this.loading = false;
				return;
			}
			this.$store.dispatch('updatePassword', {id: this.$route.params.id, password: this.password})
				.then(() => {
					this.$router.push({name: 'index'});
				})
				.catch(() => {
					this.passwordError = true;
				})
				.finally(() => {
					this.loading = false;
				});
		},
	}
}
</script>

<style scoped>

</style>
