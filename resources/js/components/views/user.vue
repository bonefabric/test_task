<template>
	<div>

		<div class="card col-6 offset-3">
			<div class="card-body">
				<h5 class="card-title"><span class="font-weight-bold">Name: </span>{{ user.name }}</h5>
				<h6 class="card-subtitle mb-2 mt-3"><span class="font-weight-bold">Email: </span>{{ user.email }}</h6>
				<p class="card-text mt-3"><span
					class="font-weight-bold">Created at: </span>{{ (new Date(user.created_at)).toLocaleString() }}</p>
				<p class="card-text"><span
					class="font-weight-bold">Updated at: </span>{{ (new Date(user.updated_at)).toLocaleString() }}</p>
				<a href="" class="card-link">Edit</a>
				<a href="" class="card-link">Delete</a>
				<a href="" class="card-link" @click.prevent="showPayments">Show payments</a>
			</div>
		</div>

		<div v-if="showingPayments">

			<div v-if="!paymentsLoading">

				<table class="table mt-5">
					<thead>
					<tr>
						<th scope="col">Sum</th>
						<th scope="col">Created at</th>
						<th scope="col">Updated at</th>
						<th scope="col">Deleted at</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="payment in payments">
						<td>{{ payment.sum }}</td>
						<td>{{ payment.created_at ? (new Date(payment.created_at)).toLocaleString() : 'No info' }}</td>
						<td>{{ payment.updated_at ? (new Date(payment.updated_at)).toLocaleString() : 'No info' }}</td>
						<td>{{ payment.deleted_at ? (new Date(payment.deleted_at)).toLocaleString() : '' }}</td>
					</tr>
					</tbody>
				</table>

			</div>
			<div v-else>
				Loading...
			</div>

		</div>

	</div>
</template>

<script>
export default {
	name: "user",
	data() {
		return {
			showingPayments: false,
			paymentsLoading: true,
			payments: [],
		}
	},
	computed: {
		user() {
			return this.$store.getters.users.find(user => user.id === this.$route.params.id)
		},
	},
	methods: {
		showPayments() {
			this.showingPayments = true;
			this.paymentsLoading = true;
			this.$store.dispatch('loadPayments', this.user.id)
				.catch(() => {
				})
				.then(result => {
					if (result) {
						this.payments = result;
					}
				})
				.finally(() => {
					this.paymentsLoading = false;
				});
		},
	}
}
</script>

<style scoped>

</style>
