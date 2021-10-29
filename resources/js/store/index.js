import Vue from 'vue';
import Vuex from 'vuex'
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		account: {
			isAuthorized: false,
			token: null,
		},
		data: {
			users: {
				loaded: false,
				list: [],
			}
		}
	},
	getters: {

		/** Account */
		isAuthorized: state => state.account.isAuthorized,
		token: state => state.account.token,
		/** End account */


		/** Data */
		users: state => state.data.users.list,
		isUsersLoaded: state => state.data.users.loaded,
		/** End data */
	},
	mutations: {

		/** Account */
		setToken: (state, token) => state.account.token = token,
		setAuthorized: (state, value) => state.account.isAuthorized = value,
		/** End account */


		/** Data */
		setUsers: (state, users) => state.data.users.list = users,
		setUsersAsLoaded: (state, value) => state.data.users.loaded = value,
		/** End data */

	},
	actions: {

		/** Initialization */
		init(context) {
			const token = localStorage.getItem('token');
			if (token === null || token.length < 30) {
				localStorage.removeItem('token')
				return;
			}
			context.commit('setAuthorized', true);
			context.commit('setToken', token);
		},
		/** End initialization */


		/** Account */
		async authorize(context, data) {
			localStorage.removeItem('token');
			const result = await axios.post('token/get', {
				email: data.email,
				password: data.password,
			});
			const token = result.data.token;
			if (token && token.length > 30) {
				localStorage.setItem('token', token);
				context.commit('setToken', token);
				context.commit('setAuthorized', true);
				return true;
			}
			return false;
		},

		logout(context) {
			context.commit('setAuthorized', false);
			context.commit('setToken', null);
			localStorage.removeItem('token');
		},
		/** End account */


		/** Data */
		async loadUsers(context) {
			context.commit('setUsersAsLoaded', false);
			context.commit('setUsers', []);
			const result = await axios.get('users', {
				headers: {
					'Authorization': 'Bearer ' + context.getters.token,
					'Accept': 'application/json'
				}
			});
			if (result.status === 200) {
				context.commit('setUsers', result.data);
			}
			context.commit('setUsersAsLoaded', true);
		},

		async loadPayments(context, id) {
			const result = await axios.get('/users/' + id + '/payments', {
				headers: {
					'Authorization': 'Bearer ' + context.getters.token,
					'Accept': 'application/json'
				}
			});
			if (result.status === 200) {
				return result.data;
			}
			return false;
		},

		async deleteUser(context, id) {
			await axios.delete('/users/' + id, {
				headers: {
					'Authorization': 'Bearer ' + context.getters.token,
					'Accept': 'application/json'
				}
			});
		},

		async updateName(context, user) {
			await axios.post('/users', {
				id: user.id,
				name: user.name
			}, {
				headers: {
					'Authorization': 'Bearer ' + context.getters.token,
					'Accept': 'application/json'
				}
			})
		},

		async updatePassword(context, user) {
			await axios.post('/users', {
				id: user.id,
				password: user.password
			}, {
				headers: {
					'Authorization': 'Bearer ' + context.getters.token,
					'Accept': 'application/json'
				}
			})
		},

		async testPayment(context, user) {
			await axios.get('/users/' + user.id + '/payments/test', {
				headers: {
					'Authorization': 'Bearer ' + context.getters.token,
					'Accept': 'application/json'
				}
			});
		}
		/** End data */
	},
});
