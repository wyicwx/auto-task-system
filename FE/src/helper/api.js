'use strict';

import {each} from 'lodash';

var csrf = 'd1pENThvMmoDIwlXeyRnCRUWLXd3AkgmMmoHf2JeY1wvDQpDVQdnOg==';
var csrfParam = '_csrf-frontend';

module.exports = {
    get: function(url, body = {}, headers) {
        var params = [];

        body[csrfParam] = csrf;

        each(body, function(value, key) {
            params.push([key, value].join('='));
        });

        if(url.indexOf('?') === -1) {
            url += '?';
        }
        url += params.join('&');

        return fetch(url, {
            method: 'get',
            headers: headers
        }).then((res) => {
            if(res.ok) {
                return res.json();
            } else {
                return Promise.reject();
            }
        }).then((data) => {
            if(data.code === 0) {
                return data.data;
            } else {
                return Promise.reject(data);
            }
        });
    },
    post: function(url, body = {}, headers) {
        body[csrfParam] = csrf;

        return fetch(url, {
            method: 'post',
            headers: headers,
            body: JSON.stringify(body)
        }).then((res) => {
            if(res.ok) {
                return res.json();
            } else {
                return Promise.reject();
            }
        }).then((data) => {
            if(data.code === 0) {
                return data.data;
            } else {
                return Promise.reject(data);
            }
        });
    }
};