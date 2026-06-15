<?php

function sortingComponent($title, $selectedOption)
{
    ?>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

        <div>
            <h2 class="mb-0 text-white fw-normal">
                <?php echo htmlspecialchars($title); ?>
            </h2>
        </div>

        <div>
            <select id="sortselect" class="form-select bg-dark text-white border-secondary" style="min-width: 220px;">

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

    </div>

    <?php
}
?>