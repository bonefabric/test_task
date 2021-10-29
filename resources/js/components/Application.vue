<template>
	<div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light" v-if="$store.getters.isAuthorized">
			<div class="container-fluid justify-content-between flex-row-reverse">
					<span class="navbar-text mr-5">
						<a href="" @click.prevent="logout">Log out</a>
					</span>
				<span class="navbar-text mr-5" v-if="$route.meta.backButton">
						<a href="" @click.prevent="$router.go(-1)">Back</a>
					</span>
			</div>
		</nav>
		<div class="container">
			<router-view class="mt-5"/>
		</div>
	</div>

</template>

<script>
export default {
	name: "Application",
	beforeMount() {
		this.$store.dispatch('init');
		this.$router.beforeEach((to, from, next) => {
			if (to.meta.guest !== true && !this.$store.getters.isAuthorized) {
				next({name: 'login'});
			}
			next();
		});

		if (!this.$store.getters.isAuthorized && this.$route.name !== 'login') this.$router.push({name: 'login'});
		if (this.$store.getters.isAuthorized && this.$route.name !== 'index') this.$router.push({name: 'index'});
	},
	methods: {
		logout() {
			this.$store.dispatch('logout');
			this.$router.push({name: 'login'});
		}
	}
}
</script>

<style scoped>

</style>
