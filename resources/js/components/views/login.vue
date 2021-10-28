<template>
	<div class="col-6 offset-3">
		<form @submit.prevent>
			<div class="form-group">
				<label for="inputEmail">Email address</label>
				<input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp"
					   placeholder="Enter email"
					   :disabled="loading" v-model="email">
			</div>
			<div class="form-group">
				<label for="inputPassword">Password</label>
				<input type="password" class="form-control" id="inputPassword" placeholder="Password"
					   :disabled="loading"
					   v-model="password">
			</div>
			<button type="submit" class="btn btn-primary w-25" :disabled="loading" @click="tryLogin">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loading"/>
				Submit
			</button>
		</form>
		<div class="alert alert-danger mt-5" role="alert" v-if="errors">
			Incorrect email or password
		</div>
	</div>
</template>

<script>
export default {
	name: "login",
	data() {
		return {
			email: '',
			password: '',
			loading: false,
			errors: false,
		}
	},
	methods: {
		tryLogin() {
			this.loading = true;
			this.errors = false;
			this.$store.dispatch('authorize', {
				email: this.email,
				password: this.password,
			})
				.then((result) => result ? this.$router.push({name: 'index'}) : this.errors = true)
				.catch(() => this.errors = true)
				.finally(() => this.loading = false);
		}
	}
}
</script>

<style scoped>

</style>
