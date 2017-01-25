'use strict';

import {get} from '../helper/api';

module.exports = {
    state: {
        loading: true,
        list: [],
        pages: {
            totalCount: 0
        }
    },
    mutations: {
        'task.list.reset': function(state) {
            state.loading = true;
            state.list = [];
            state.pages = {};
        },
        'task.list.success': function(state, data) {
            state.loading = false;
            state.list = data.list;
            state.pages = data.pages;
        },
        'task.list.fail': function() {

        }
    },
    actions: {
        'task.list.fetch': function(context, params = {}) {
            context.commit('task.list.reset');

            get('/task/list', {
                page: params.page || 1
            }).then((data) => {
                context.commit('task.list.success', data);
            });
        }
    }
};