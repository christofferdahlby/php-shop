<?php

function productComponent($product)
{
    ?>
    <!--https://en.wikipedia.org/wiki/Jane_Doe_%28album%29#/media/File:Converge-JaneDoe.jpg-->
    <!--https://dummyimage.com/450x300/dee2e6/6c757d.jpg-->
    <div class="col mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <img class="card-img-top"
                src="<?php echo $product->imageUrl ? $product->imageUrl : "https://dummyimage.com/450x300/dee2e6/6c757d.jpg"; ?>"
                alt="
            ..." />
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Record title-->
                    <h5 class="fw-bolder"><?php echo $product->record_title; ?></h5>
                    <!-- Artist name-->
                    <p class="text-muted"><?php echo $product->artist; ?></p>
                    <!-- Product price-->
                    SEK <?php echo $product->price; ?>
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                        href="product?id=<?php echo $product->id; ?>">View options</a></div>
            </div>
        </div>
    </div><?php
} ?>