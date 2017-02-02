'use strict';

import { get, post } from '../helper/api.js';
import { pick } from 'lodash';

module.exports = {
    state: {
        logCrontab: {
            list: [],
            pages: {}
        }
    },
    mutations: {
        'admin.setLogCrontab': function(state, data) {
            state.logCrontab.list = data.list;
            state.logCrontab.pages = data.pages
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

            return get('/admin/logcrontab', data).then((data) => {
                context.commit('admin.setLogCrontab', data);
                return data;
            });
        }
    }
}