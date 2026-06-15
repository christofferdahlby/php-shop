<?php

function productComponent($product)
{
    ?>
    <div class="col mb-5">
        <a href="product?id=<?php echo $product->id; ?>" class="text-decoration-none text-reset">

            <div class="card product-card h-100 bg-black text-white border-0 rounded-0 shadow-sm">

                <!-- Product image -->
                <img class="card-img-top rounded-0"
                    src="<?php echo $product->imageUrl ? $product->imageUrl : "https://dummyimage.com/450x450/000/fff"; ?>"
                    alt="<?php echo htmlspecialchars($product->record_title); ?>"
                    style="aspect-ratio: 1 / 1; object-fit: cover;">

                <!-- Product details -->
                <div class="card-body py-3">

                    <h6 class="mb-1">
                        <?php echo $product->record_title; ?>
                    </h6>

                    <p class="text-secondary mb-0">
                        <?php echo $product->artist; ?>
                    </p>

                </div>

            </div>

        </a>
    </div><?php
} ?>