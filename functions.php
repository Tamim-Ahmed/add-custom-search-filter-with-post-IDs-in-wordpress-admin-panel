<?php
// Add a dropdown filter for job listings by post ID in the WordPress admin panel
function cwpai_add_job_listing_filter() {
  global $typenow;
  
  // Check if the current screen is the job_listing post type
  if ($typenow == 'job_listing') {
    // Get the list of job listings
    $job_listings = get_posts(array(
      'post_type' => 'job_listing',
      'numberposts' => -1,
      'post_status' => 'publish',
    ));
    
    // Display the dropdown filter
    echo '<select name="job_listing_filter" id="job_listing_filter">
            <option value="">All</option>'; // Default option for all
      
      // Loop through each job listing
      foreach ($job_listings as $job_listing) {
        echo '<option value="' . $job_listing->ID . '">' . get_the_title($job_listing->ID) . '</option>';
      }
      
    echo '</select>';
  }
}
add_action('restrict_manage_posts', 'cwpai_add_job_listing_filter');

// Filter job listings in the admin panel by post ID
function cwpai_filter_job_listings($query) {
  global $pagenow, $typenow;
  
  // Check if the current screen is the job_listing post type and we have a filter selected
  if ($pagenow == 'edit.php' && $typenow == 'job_listing' && isset($_GET['job_listing_filter'])) {
    $query->query_vars['post__in'] = array($_GET['job_listing_filter']);
  }
  
  return $query;
}
add_filter('parse_query', 'cwpai_filter_job_listings');


// Replace the post type slug "job_listing" with your desired post type.
