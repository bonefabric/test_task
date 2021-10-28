import Vue from 'vue';
import Vuex from 'vuex'

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
		isAuthorized: state => state.account.isAuthorized,
		token: state => state.account.token,
	},
	mutations: {

		//Account
		setToken: (state, token) => state.account.token = token,
		setAuthorized: (state, value) => state.account.isAuthorized = value,

	},
	actions: {

		init(context) {
			const token = localStorage.getItem('token');
			if (token === null || token.length !== 42) {
				localStorage.removeItem('token')
				return;
			}
			context.commit('setAuthorized', true);
			context.commit('setToken', token);
		},

		async authorize(context, data) {
			localStorage.removeItem('token');
			const result = await axios.post('token/get', {
				email: data.email,
				password: data.password,
			});
			const token = result.data.token;
			if (token && token.length === 42) {
				localStorage.setItem('token', token);
				context.commit('setToken', token);
				context.commit('setAuthorized', true);
				return true;
			}
			return false;
		},

	},
});
