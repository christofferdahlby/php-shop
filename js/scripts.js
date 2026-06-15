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

<div
    class="card border-0"
    style="background-color:#000; border-radius:0;">

    <div class="row g-0 align-items-stretch" style="min-height:220px;">

        <!-- Cover -->
        <div class="col-md-4">

            <img
                src="${cartItem.imageUrl}"
                alt="${cartItem.productName}"
                class="w-100 h-100"
                style="
                    object-fit:cover;
                    min-height:220px;
                    display:block;
                "
            >

        </div>

        <!-- Product Info -->
        <div class="col-md-6 text-white p-4 d-flex flex-column justify-content-between">

            <h4 class="fw-normal mb-2">
                ${cartItem.productName}
            </h4>

            <p class="text-secondary mb-4">
                ${cartItem.artist}
            </p>

            <div class="d-flex gap-4">

                <div>
                    <small class="text-secondary d-block">
                        Quantity
                    </small>
                    <strong>
                        ${cartItem.quantity}
                    </strong>
                </div>

                <div>
                    <small class="text-secondary d-block">
                        Unit Price
                    </small>
                    <strong>
                        SEK ${cartItem.productPrice}
                    </strong>
                </div>

                <div>
                    <small class="text-secondary d-block">
                        Total
                    </small>
                    <strong>
                        SEK ${cartItem.quantity * cartItem.productPrice}
                    </strong>
                </div>

            </div>

            <!-- Quantity Controls -->
            <div class="d-flex align-items-center gap-1 mt-4">

                <button
                    class="btn btn-dark"
                    style="width:40px;height:40px;"
                    onclick="jsremoveFromCart(${cartItem.productId})">

                    −

                </button>

                <button
                    class="btn bg-secondary text-white border-0 disabled"
                    style="width:60px;height:40px;">

                    ${cartItem.quantity}

                </button>

                <button
                    class="btn btn-dark"
                    style="width:40px;height:40px;"
                    onclick="jsaddToCart(${cartItem.productId})">

                    +

                </button>

            </div>

        </div>

        <!-- Actions -->
        <div class="col-md-2 p-4 d-flex flex-column justify-content-end align-items-end gap-2">

            <a
                href="/product?id=${cartItem.productId}"
                class="view-record-link">

                View

            </a>

            <a
                href="#"
                class="cart-link-remove"
                onclick="jsRemoveProduct(${cartItem.productId}, ${cartItem.quantity}); return false;">
                Remove
            </a>

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

async function jsRemoveProduct(productId, quantity)
{
    const response = await fetch(
        `/jsremoveFromCart?id=${productId}&quantity=${quantity}&freightRuleId=${getSelectedFreightRuleId()}`
    );

    const data = await response.json();

    if (data.success)
    {
        document.getElementById('cartItemCount').innerText =
            data.cartItemCount;

        drawCart(
            data.cartItems,
            data.cartTotalPrice,
            data.cartTotalWeight,
            data.freightCost
        );
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