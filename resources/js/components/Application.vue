<template>
	<div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light" v-if="$store.getters.isAuthorized">
			<div class="container-fluid justify-content-end">
					<span class="navbar-text mr-5">
						<a href="" @click.prevent>Log out</a>
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
	mounted() {
		this.$store.dispatch('init');
		this.$router.beforeEach((to, from, next) => {
			if (to.meta.guest !== true && !this.$store.getters.isAuthorized) {
				next({name: 'login'});
			}
			next();
		});

		if (!this.$store.getters.isAuthorized && this.$route.name !== 'login') this.$router.push({name: 'login'});
		if (this.$store.getters.isAuthorized && this.$route.name !== 'index') this.$router.push({name: 'index'});
	}
}
</script>

<style scoped>

</style>
