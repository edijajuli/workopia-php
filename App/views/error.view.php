<?php loadPartials('head'); ?>
<?php loadPartials('navbar'); ?>

<section>
    <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3"><?= $status; ?></div>
        <p class="text-center text-2xl mb-4">
            <?= $message; ?>
        </p>
        <a class="block text-center text-blue-500" href="/listings">
            <i class="fa fa-arrow-alt-circle-left"></i> Go Back To Listings</a>
    </div>
</section>


<?php loadPartials('footer'); ?>