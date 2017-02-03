'use strict';

import {get} from '../helper/api';
import { each } from 'lodash';

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
            each(data.list, (item) => {
                if(!item.user) {
                    item.user = {};
                }
            });
            state.loading = false;
            state.list = data.list;
            state.pages = data.pages;
        },
        'model.list.fail': function(state) {
            state.loading = false;
        },
        'model.list.loading': function(state) {
            state.loading = true;
        },
        'model.list.reset': function(state) {
            state.loading = true;
            state.list = [];
            state.pages = {
                page: 1,
                total: 0,
                perpage: 20,
                total: 1
            };
        }
    },
    actions: {
        'model.list.fetch': function(context, params = {}) {
            context.commit('model.list.loading');

            get('/model/list', {
                page: params.page || 1
            }, false, false, false).then((data) => {
                context.commit('model.list.success', data);
            }, () => {
                context.commit('model.list.fail');
            });
        },
        'model.market.fetch': function(context, params ={}) {
            context.commit('model.list.loading');

            get('/model/list', {
                page: params.page || 1,
                market: 1
            }, false, false, false).then((data) => {
                context.commit('model.list.success', data);
            }, () => {
                context.commit('model.list.fail');
            });
        }
    }
};