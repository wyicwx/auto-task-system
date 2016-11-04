'use strict';

import {each} from 'lodash';

function parseBody(body) {
    return each(body, function(value, key) {
        params.push([key, value].join('='));
    }).join('&');
}
module.exports = {
    get: function(url, body, headers) {
        var params = [];

        if(url.indexOf('?') === -1) {
            url += '?';
        }

        url += parseBody(body);

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
            body: parseBody(body)
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