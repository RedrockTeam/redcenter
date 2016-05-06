import Vue from "../../node_modules/vue"
import $ from "../../node_modules/jquery"

var containerData = {
    stuID: '',
    code: ''
};

var containerVM = new Vue ({
    el: '#vue-container',
    data: containerData,
    methods: {
        post: function () {
            $.ajax({
                method: 'POST',
                url: '',
                data: {

                }
            }).complete(function (msg) {

            }).fail(function (jqXHR, textStatus) {
                alert(`Request failed : ${textStatus}`);
            });
        }
    }
}) 