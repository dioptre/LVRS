<div class="timeline-wrapper">
    <div class="container">

        <!-- Render sub templates -->
        <?php
            foreach($data->children()->visible() as $section) {
                snippet($section->template(), array('data' => $section));
            }
        ?>


    </div>
</div>