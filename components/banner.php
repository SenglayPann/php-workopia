<?php
  function banner($title = 'Unlock Your Career Potential', $subtitle = 'Discover the perfect job opportunity for you.') {
    echo
    str_replace(['$title', '$subtitle'], [$title, $subtitle], '
      <section class="bg-blue-900 text-white py-6 text-center">
        <div class="container mx-auto">
          <h2 class="text-3xl font-semibold">$title</h2>
          <p class="text-lg mt-2">
            $subtitle
          </p>
        </div>
      </section>
    ');
  }
?>