'use strict';

import { get, post } from '../helper/api.js';
import { pick } from 'lodash';

module.exports = {
    state: {
        id: '',
        nickname: '',
        email: ''
    },
    actions: {
        'user.profile': function(context, params) {
            return get('/user/profile').then((data) => {
                context.commit('user.setProfile', data);

                return data;
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
        'user.setProfile': function(state, data) {
            state.id = data.id;
            state.nickname = data.nickname;
            state.email = data.email;
        }
    }
};