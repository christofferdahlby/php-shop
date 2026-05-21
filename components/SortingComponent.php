<?php

function sortingComponent($title, $selectedOption)
{
    ?>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <h2 class="fw-bolder mb-0">
            <?php echo htmlspecialchars($title); ?>
        </h2>

        <select id="sortselect" class="form-select w-auto shadow-sm">

            <option value="record_title-asc" <?php echo $selectedOption === 'record_title-asc' ? 'selected' : ''; ?>>
                Title A-Z
            </option>

            <option value="record_title-desc" <?php echo $selectedOption === 'record_title-desc' ? 'selected' : ''; ?>>
                Title Z-A
            </option>

            <option value="price-asc" <?php echo $selectedOption === 'price-asc' ? 'selected' : ''; ?>>
                Price: Low to High
            </option>

            <option value="price-desc" <?php echo $selectedOption === 'price-desc' ? 'selected' : ''; ?>>
                Price: High to Low
            </option>

        </select>

    </div>

    <?php
}
?>