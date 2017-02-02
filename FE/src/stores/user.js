'use strict';

import { get, post } from '../helper/api.js';
import { pick } from 'lodash';

module.exports = {
    state: {
        id: '',
        nickname: '',
        email: '',
        role: 0,
        loading: false
    },
    actions: {
        'user.load': function(context, params) {
            context.commit('user.setProfile', window.taskUser);
        },
        'user.profile': function(context, params) {
            context.commit('user.loading');

            return get('/user/profile', {}, false, false, false).then((data) => {
                context.commit('user.setProfile', data);

                return data;
            }, () => {
                context.commit('user.loading.false');
            });
        },
        'user.updateProfile': function(context, params) {
            var keys = [
                'nickname',
                'email'
            ];

            var data = pick(params, keys);

            return post('/user/profile', data).then((data) => {
                context.dispatch('user.profile');
                return data;
            });
        },
        'user.password': function(context, params) {
            var keys = [
                'password',
                'newpassword',
                'repassword'
            ];

            var data = pick(params, keys);

            return post('/user/password', data);
        }
    },
    mutations: {
        'user.setProfile': function(state, data = {}) {
            state.id = data.id;
            state.nickname = data.nickname;
            state.email = data.email;
            state.role = data.role;
            state.avatar = data.avatar;
            state.loading = false;
        },
        'user.loading': function(state) {
            state.loading = true;
        },
        'user.loading.false': function(state) {
            state.loading = false;
        }
    }
};