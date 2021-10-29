import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import index from '../components/views/index';

export default new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/login',
			name: 'login',
			component: () => import('../components/views/login'),
			meta: {
				guest: true
			}
		},
		{
			path: '/',
			name: 'index',
			component: index,
		},
		{
			path: '/user/:id',
			name: 'user',
			component: () => import('../components/views/user'),
			meta: {
				backButton: true,
			}
		},
		{
			path: '/user/edit/:id',
			name: 'editUser',
			component: () => import('../components/views/editUser'),
			meta: {
				backButton: true,
			}
		},
	]
});
