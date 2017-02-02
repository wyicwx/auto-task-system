'use strict';

import { get, post } from '../helper/api.js';
import { pick } from 'lodash';

module.exports = {
    state: {
        logCrontab: {
            list: [],
            pages: {},
            loading: false
        }
    },
    mutations: {
        'admin.setLogCrontab': function(state, data) {
            state.logCrontab.list = data.list;
            state.logCrontab.pages = data.pages;
            state.logCrontab.loading = false;
        },
        'admin.logCrontab.loading': function(state, data) {
            state.logCrontab.loading = true;
        },
        'admin.logCrontab.loading.false': function(state, data) {
            state.logCrontab.loading = false;
        }
    },
    actions: {
        'admin.adduser': function(context, params) {
            var keys = [
                'email',
                'nickname'
            ];

            var data = pick(params, keys);

            return post('/admin/register', data);
        },
        'admin.resetpassword': function(context, params) {
            var keys = [
                'email'
            ];

            var data = pick(params, keys);

            return post('/admin/resetpassword', data);
        },
        'admin.logcrontab': function(context, params) {
            var keys = [
                'page'
            ];

            var data = pick(params, keys);
            context.commit('admin.logCrontab.loading');

            return get('/admin/logcrontab', data).then((data) => {
                context.commit('admin.setLogCrontab', data);
                return data;
            }, () => {
                context.commit('admin.logCrontab.loading.false');
            });
        }
    }
}