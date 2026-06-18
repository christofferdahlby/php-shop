<?php

function productComponent($product)
{
    ?>
    <div class="col mb-5">

        <div class="product-card card h-100 border-0 position-relative overflow-hidden" style="
            background:#000;
            border-radius:0;
            cursor:pointer;
        " onclick="window.location='product?id=<?php echo $product->id; ?>'">

            <!-- Product image -->
            <img class="card-img-top"
                src="<?php echo $product->imageUrl ?: 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'; ?>"
                alt="<?php echo htmlspecialchars($product->record_title); ?>" style="
                border-radius:0;
                width:100%;
                object-fit:cover;
            ">

            <!-- Product details -->
            <div class="card-body text-white">

                <h6 class="mb-1">
                    <?php echo htmlspecialchars($product->record_title); ?>
                </h6>

                <p class="text-secondary mb-0">
                    <?php echo htmlspecialchars($product->artist); ?>
                </p>

            </div>

            <!-- BUY button -->
            <div class="position-absolute bottom-0 end-0 p-3 buy-overlay" style="
        opacity:0;
        transition:all .2s ease;
        transform:translateY(10px);
    ">

                <a href="#" class="buy-record-link" onclick="
            event.stopPropagation();
            jsaddToCart(<?php echo $product->id; ?>);
            return false;
        ">

                    BUY

                </a>

            </div>

        </div>

    </div><?php
} ?>