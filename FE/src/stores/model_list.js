'use strict';

import {get} from '../helper/api';

module.exports = {
    state: {
        loading: true,
        list: [],
        pages: {
            page: 1,
            total: 0,
            perpage: 20,
            total: 1
        }
    },
    mutations: {
        'model.list.success': function(state, data) {
            state.loading = false;
            state.list = data.list;
            state.pages = data.pages;
        },
        'model.list.fail': function(state) {
            state.loading = false;
        },
        'model.list.loading': function(state) {
            state.loading = true;
        }
    },
    actions: {
        'model.list.fetch': function(context, params = {}) {
            context.commit('model.list.loading');

            get('/model/list', {
                page: params.page || 1
            }).then((data) => {
                context.commit('model.list.success', data);
            }, () => {
                context.commit('model.list.fail');
            });
        }
    }
}