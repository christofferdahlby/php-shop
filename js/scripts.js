/*!
* Start Bootstrap - Shop Homepage v5.0.6 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

function drawCart(cartItems, cartTotalPrice, cartTotalWeight, freightCost) {


    const cartTotalPriceElement = document.getElementById('cartTotalPrice');

    if (cartTotalPriceElement) {
        cartTotalPriceElement.innerText = cartTotalPrice;
    }

    const cartTotalWeightElement = document.getElementById('cartTotalWeight');

    if (cartTotalWeightElement) {
        document.getElementById('cartTotalWeight').innerText = cartTotalWeight;
    }

    const freightCostElement = document.getElementById('freightCost');

    if (freightCostElement) {
        document.getElementById('freightCost').innerText = freightCost;
    }

    const cartItemElement = document.getElementById('cartItemElement');

    if (!cartItemElement) {
        return;
    }

    // Empty cart state
    if (cartItems.length === 0) {

        cartItemElement.innerHTML = `
            <div class="alert alert-info">
                Your cart is empty.
                <a href="/">Continue shopping</a>.
            </div>
        `;

        return;
    }

        cartItemElement.innerHTML = "";

        cartItems.forEach(cartItem => {

            cartItemElement.innerHTML += `

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-2 text-center">
                                <img 
                                    src="${cartItem.imageUrl}"
                                    alt="${cartItem.productName}"
                                    class="img-fluid rounded"
                                    style="max-height: 140px; object-fit: cover;"
                                >
                            </div>

                            <div class="col-md-7">

                                <h4 class="mb-1">
                                    ${cartItem.productName}
                                </h4>

                                <p class="text-muted mb-3">
                                    ${cartItem.artist}
                                </p>

                                <div class="d-flex gap-4">

                                    <div>
                                        <small class="text-muted d-block">Quantity</small>
                                        <strong>
                                            ${cartItem.quantity}
                                        </strong>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Unit price</small>
                                        <strong>
                                            SEK ${cartItem.productPrice}
                                        </strong>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Total</small>
                                        <strong>
                                            SEK ${cartItem.quantity * cartItem.productPrice}
                                        </strong>
                                    </div>

                                </div>

                                

                                    <div class="d-flex align-items-center gap-1 mt-3">

    <button
        class="btn btn-outline-dark btn-sm"
        style="width: 30px;"
        onclick="jsremoveFromCart(${cartItem.productId})">
        -
    </button>

    <button
        class="btn btn-sm bg-light border-0 disabled"
        style="width: 50px;">
        ${cartItem.quantity}
    </button>

    <button
        class="btn btn-outline-dark btn-sm"
        style="width: 30px;"
        onclick="jsaddToCart(${cartItem.productId})">
        +
    </button>

</div>

                                

                            </div>

                            </div>

                        </div>

                    </div>

                </div>

            `;
        });
    }

async function fetchCartItems() {
    let resp = await fetch('/javascriptFetchCart');
    let data = await resp.json();
    console.log(data);
    return data;
}

function getSelectedFreightRuleId() {
    const selectElement = document.getElementById('freightRuleSelect');
    if (selectElement) {
        return selectElement.value;
    }
    return null;
}

async function jsaddToCart(productId) {
    const response = await fetch(`/jsaddToCart?id=${productId}&freightRuleId=${getSelectedFreightRuleId()}`);
    const data = await response.json();
    if (data.success) {
        // Update cart count and price
                document.getElementById('cartItemCount').innerText = data.cartItemCount;
                drawCart(data.cartItems, data.cartTotalPrice, data.cartTotalWeight, data.freightCost);
    }
}

async function jsremoveFromCart(productId) {
    const response = await fetch(`/jsremoveFromCart?id=${productId}&freightRuleId=${getSelectedFreightRuleId()}`);
    const data = await response.json();
    if (data.success) {
        // Update cart count and price
                document.getElementById('cartItemCount').innerText = data.cartItemCount;
                drawCart(data.cartItems, data.cartTotalPrice, data.cartTotalWeight, data.freightCost);
    }
}

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