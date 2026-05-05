/*!
* Start Bootstrap - Shop Homepage v5.0.6 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

const sortSelect = document.getElementById("sortselect");

if (sortSelect) {
    sortSelect.addEventListener("change", function () {
        const [sort, order] = this.value.split("-");

        const  urlSearchParams = new URLSearchParams(window.location.search);
        urlSearchParams.set("sort", sort);
        urlSearchParams.set("order", order);

        window.location.search = urlSearchParams.toString();

        // alert('selected value: ' + this.value);

    });
}