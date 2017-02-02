'use strict';

import { get } from '../helper/api.js';

module.exports = {
    state: {
        list: [],
        loading: false,
        pages: {}
    },
    mutations: {
        'statistics.task.list.loading': function(state) {
            state.loading = true;
        },
        'statistics.task.list.success': function(state, data) {
            state.list = data.list;
            state.pages = data.pages;
            state.loading = false;
        },
        'statistics.task.list.fail': function(state) {
            state.loading = false;
        }
    },
    actions: {
        'statistics.task.list.fetch': function(context, params) {
            var keys = [
                'page',
                'tid'
            ];

            var data = _.pick(params, keys);

            context.commit('statistics.task.list.loading');

            return get('/schedule/list', data, false, false, false).then((data) => {
                context.commit('statistics.task.list.success', data);

                return data;
            }, () => {
                context.commit('statistics.task.list.fail');
            });
        }
    }
};