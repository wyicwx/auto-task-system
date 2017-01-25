'use strict';

import {each} from 'lodash';

module.exports = {
    get: function(url, body, headers) {
        var params = [];

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
                Promise.reject();
            }
        }).then((data) => {
            if(data.code === 0) {
                return data.data;
            } else {
                Promise.reject(data);
            }
        });
    },
    post: function(url, body, header) {
        return fetch(url, {
            method: 'post',
            headers: headers,
            body: JSON.stringify(body)
        }).then((res) => {
            if(res.ok) {
                return res.json();
            } else {
                Promise.reject();
            }
        }).then((data) => {
            if(data.code === 0) {
                return data.data;
            } else {
                Promise.reject(data);
            }
        });
    }
};