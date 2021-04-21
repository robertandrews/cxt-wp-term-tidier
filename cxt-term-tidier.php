<?php

/**
 * Plugin Name: Context Term Tidier Yes
 * Plugin URI: http://www.contexthq.com
 * Description: Uses Google Cloud Natural Language / Text Classification to classify a string
 * Version: 1.0.0
 * Author: Robert Andrews
 * Author URI: http://www.contexthq.com
 */




 /*
 Thanks to:
  The Complete Guide to the WordPress Settings API - https://code.tutsplus.com/series/the-complete-guide-to-the-wordpress-settings-api--cms-624
  Making an Admin Options Page With the WordPress Settings API - https://wpshout.com/making-an-admin-options-page-with-the-wordpress-settings-api/
 */







/* ########################################################################## *
 *
 *   SETTINGS PAGE
 *
/* ########################################################################## */




/* ------------------------------------------------------------------------ *
 * 1. Navigation to your settings page.
 * ------------------------------------------------------------------------ */

/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
add_action( 'admin_menu', 'cxt_add_settings_admin_menu' );

function cxt_add_settings_admin_menu(  ) {
    add_options_page(                       // Administration Pages addable: https://codex.wordpress.org/Administration_Menus
         'Context Term Tidier',                     // Page title: The text to be displayed in the title tags of the page when the menu is selected.
         'Context Term Tidier',                     // Menu text: The text to be used for the menu.
         'manage_options',                  // Capability: The capability required for this menu to be displayed to the user.
         'magic-terms-settings',            // Menu slug: The slug name to refer to this menu by (should be unique for this menu).
         'cxt_options_page'                 // Callback function: The function to be called to output the content for this page
     );
} // end cxt_add_settings_admin_menu






/* ------------------------------------------------------------------------ *
 * 2. Setting Registration / Creation
 * ------------------------------------------------------------------------ */

 /*
 Main Settings:
 # GCloud API key
 Taxonomy Settings:
 # Source taxonomy
 # Entity types > taxonomies (map)
 */


/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
add_action(
    'admin_init',
    'cxt_settings_init'
);

function cxt_settings_init(  ) {

    // Registering your Settings
    register_setting(
        'pluginPage',                       // A settings group name. Should correspond to a whitelisted option key name
        'cxt_settings'                      // The name of an option to sanitize and save
    );


    // Create section of Page
    add_settings_section(
        'cxt_pluginPage_main',              // The name of the section
        'Main Settings',                    // The title for the section. This will display on the settings page eventually
        'cxt_settings_main_callback',       // Name of a callback function to render before the fields you add to this section
        'pluginPage'                        // The name of the page to which this section belongs
    );

    // Add fields to that section
    // Your setting should already exist, which is why our register_setting call precedes our add_settings_field one
    add_settings_field(
        'cxt_gcloud',                       // The name of the setting for which you’re making your field
        'Google Cloud API key ',            // Left: The title for that settings field
        'cxt_gcloud_render',                // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_main'               // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_sourcetax',                    // The name of the setting for which you’re making your field
        'Source taxonomy ',                 // Left: The title for that settings field
        'cxt_sourcetax',                    // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_main'                // The section in that page to which this field should be added
    );
    /*
    add_settings_field(
        'cxt_alwayson',                     // The name of the setting for which you’re making your field
        'Always on ',                       // Left: The title for that settings field
        'cxt_alwayson',                     // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_main'               // The section in that page to which this field should be added
    );
    */




    // Create section of Page
    add_settings_section(
        'cxt_pluginPage_map',               // The name of the section
        'Re-Assign Terms',                  // The title for the section. This will display on the settings page eventually
        'cxt_settings_map_callback',        // Name of a callback function to render before the fields you add to this section
        'pluginPage'                        // The name of the page to which this section belongs
    );

    // Add fields to that section
    // Your setting should already exist, which is why our register_setting call precedes our add_settings_field one
    add_settings_field(
        'cxt_goo_unknown',                   // The name of the setting for which you’re making your field
        'UNKNOWN ',                         // Left: The title for that settings field
        'cxt_goo_unknown_render',            // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_person',                    // The name of the setting for which you’re making your field
        'PERSON ',                          // Left: The title for that settings field
        'cxt_goo_person_render',             // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_location',                  // The name of the setting for which you’re making your field
        'LOCATION ',                        // Left: The title for that settings field
        'cxt_goo_location_render',           // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_organization',              // The name of the setting for which you’re making your field
        'ORGANIZATION ',                    // Left: The title for that settings field
        'cxt_goo_organization_render',       // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_event',                     // The name of the setting for which you’re making your field
        'EVENT ',                           // Left: The title for that settings field
        'cxt_goo_event_render',              // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_workofart',                    // The name of the setting for which you’re making your field
        'WORK_OF_ART ',                     // Left: The title for that settings field
        'cxt_goo_workofart_render',             // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_consumergood',                    // The name of the setting for which you’re making your field
        'CONSUMER_GOOD ',                     // Left: The title for that settings field
        'cxt_goo_consumergood_render',             // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );
    add_settings_field(
        'cxt_goo_other',                    // The name of the setting for which you’re making your field
        'OTHER ',                     // Left: The title for that settings field
        'cxt_goo_other_render',             // Right: The (name of the) function that’ll render your field
        'pluginPage',                       // The slug name of the page into which this setting should appear
        'cxt_pluginPage_map'                // The section in that page to which this field should be added
    );

} // end cxt_settings_init







/* ------------------------------------------------------------------------ *
* 3. Field Callbacks
* ------------------------------------------------------------------------ */

/**
 * These functions render the interface elements for toggling the visibility of the header element.
 *
 * They accept an array of arguments and expect the first element in the array to be the description
 * to be displayed next to the checkbox.
 */

function cxt_gcloud_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<input type='text' name='cxt_settings[cxt_gcloud]' value='<?php echo $options['cxt_gcloud']; ?>'>
<p class="description">
    Term Tidier is powered by <a href="https://cloud.google.com/natural-language/">Google Cloud Natural Language</a>.
    You need an account.
</p>
<ul>
    <li>Create a <a href="https://cloud.google.com/free/">free Google Cloud account</a>.</li>
    <li>In your <a href="https://console.cloud.google.com">Google Cloud Console</a>, create a new project.</li>
    <li>In your Project view, go to Menu > APIs & Services > Credentials.</li>
    <li>Click the "Create credentials" button, then "API key". In the "API key created" dialog box, copy the
        newly-created API key and paste it here.</li>
</ul>
<p class="description">
    This allows Term Tidier to process <a
        href="https://cloud.google.com/natural-language/#natural-language-api-pricing">up to 5,000 terms per month</a>
    for free.
</p>
<?php

}

function cxt_sourcetax(  ) {
    $options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_sourcetax]'>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_sourcetax'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<p class="description">
    Term Tidier will examine and reclassify terms in this taxonomy.
</p>
<?php

}
/*
function cxt_alwayson(  ) {
    $options = get_option( 'cxt_settings' );
	?>
<input type='checkbox' name='cxt_settings[cxt_alwayson]' <?php checked( $options['cxt_alwayson'], 1 ); ?> value='1'>
<p class="description">
    If checked, Term Tidier will re-assign all newly-added 'Source Taxonomy' terms in the above taxonomy, as they are
    created, with the below rules.
</p>
<p class="description">
    If unchecked, you can run manually, on all 'Source Taxonomy' terms at once, from <a
        href="/wp-admin/tools.php?page=magic-terms">the plugin page</a>.
</p>
<?php

}
*/




function cxt_goo_unknown_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_unknown]'>
    <option value='' <?php selected( $options['cxt_goo_unknown'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_unknown'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<!--
    <p class="description">
        Setting this to the same as "Source taxonomy" above means terms which Term Tidier could not re-classify will be left in their original taxonomy.
    </p>
    -->
<?php

}

function cxt_goo_person_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_person]'>
    <option value='' <?php selected( $options['cxt_goo_person'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_person'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}

function cxt_goo_location_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_location]'>
    <option value='' <?php selected( $options['cxt_goo_location'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_location'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}

function cxt_goo_organization_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_organization]'>
    <option value='' <?php selected( $options['cxt_goo_organization'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_organization'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}

function cxt_goo_event_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_event]'>
    <option value='' <?php selected( $options['cxt_goo_event'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_event'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}

function cxt_goo_workofart_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_workofart]'>
    <option value='' <?php selected( $options['cxt_goo_workofart'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_workofart'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}

function cxt_goo_consumergood_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_consumergood]'>
    <option value='' <?php selected( $options['cxt_goo_consumergood'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_consumergood'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}

function cxt_goo_other_render(  ) {

	$options = get_option( 'cxt_settings' );
	?>
<select name='cxt_settings[cxt_goo_other]'>
    <option value='' <?php selected( $options['cxt_goo_other'], $taxonomy ); ?>>None</option>
    <?php
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomy_details = get_taxonomy($taxonomy); ?>
    <option value='<?php echo $taxonomy; ?>' <?php selected( $options['cxt_goo_other'], $taxonomy ); ?>>
        <?php echo $taxonomy_details->label; ?></option>
    <?php } ?>
</select>
<?php

}



/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the General Options page.
 *
 * It is called from the 'sandbox_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */

function cxt_settings_main_callback(  ) {

	// echo 'This section description';

} // end cxt_settings_main_callback



function cxt_settings_map_callback(  ) {

	echo '<p>When Term Tidier determines your source terms to be <a href="https://gcloud.readthedocs.io/en/latest/_modules/google/cloud/language/entity.html#EntityType">entities</a> on the left, they will be re-assigned to your taxonomies selected on the right.</p>';
    echo '<p>If you do not yet have sufficient multiple taxonomies to take advantage, <a href="https://www.wpbeginner.com/wp-tutorials/create-custom-taxonomies-wordpress/">create them</a> by using a "custom taxonomies" plugin or by registering your own custom taxonomies through code.</p>';
    echo '<p>To deny re-classification of a given entity type, choose a target of "None".</p>';
    echo '<p>Setting \'None\' means Term Tidier will not re-classify terms deemed to be the specified entity. Selecting a target taxonomy that matches your source taxonomy will have the same effect; the term will be re-classified, but in the same taxonomy as originally found.</p>';

} // end cxt_settings_main_callback




/* ------------------------------------------------------------------------ *
 * Page Callback
 * ------------------------------------------------------------------------ */

/**
 * Renders the basic display of the menu page for the theme.
 */
function cxt_options_page(  ) {

		?>

<div class="wrap">

    <form action='options.php' method='post'>

        <h1>Context Term Tidier Settings</h1>

        <!--
                <p>Many  WordPress installs suffer from cramming hundreds or thousands of varied taxonomy terms in to a limited number of ill-suited, all-purpose taxonomies (eg. the default "categories" and "tags").</p>
				<p>These are better off split in to dedicated taxonomies. For example, storing "Bill Gates" and "Microsoft" terms in "tags" is not optimal, because one is a <em>person</em> whilst the other is a <em>company</em>.<p>
                <p>There is no straightforward way to split up existing taxonomies more granularly in this way, except for  labour-intensive and manual, technical effort. So, many WordPress installs continue to suffer from not having created granular taxonomies intentionally at the outset.</p>
                <p>Term Tidier tidies up messy taxonomies like these automatically. It uses natural language processing and knowledge graph technology to determine the real <a href="https://gcloud.readthedocs.io/en/latest/_modules/google/cloud/language/entity.html#EntityType">entity type</a> of existing terms, then re-assigns them each to a more appropriate, alternative taxonomy.</p>
                -->

        <?php
    			settings_fields( 'pluginPage' );
    			do_settings_sections( 'pluginPage' );
    			submit_button();
    			?>

    </form>

</div>

<?php

}







/* ******************************************************************************************************************************************** */














/* ########################################################################## *
 *
 *   PLUGIN PAGE
 *
/* ########################################################################## */

/* ------------------------------------------------------------------------ *
 * Menu Item
 * ------------------------------------------------------------------------ */

add_action( 'admin_menu', 'cxt_add_plugin_admin_menu' );

function cxt_add_plugin_admin_menu(  ) {
    /*
    add_management_page(                    // Administration Pages addable: https://codex.wordpress.org/Administration_Menus
         'Term Tidier',                     // Page title: The text to be displayed in the title tags of the page when the menu is selected.
         'Term Tidier',                     // Menu text: The text to be used for the menu.
         'manage_options',                  // Capability: The capability required for this menu to be displayed to the user.
         'magic-terms',                     // Menu slug: The slug name to refer to this menu by (should be unique for this menu).
         'cxt_plugin_page'                  // Callback function: The function to be called to output the content for this page
     );
     */

     // Per https://www.youtube.com/watch?v=7pO-FYVZv94
     global $cxt_settings;
     $cxt_settings = add_management_page(
         __('Context Term Tidier Demo', 'cxt'),
          __('Context Term Tidier', 'cxt'),
          'manage_options',
          'magic-terms',
          'cxt_plugin_page'
      );

} // end cxt_add_plugin_admin_menu




/* ------------------------------------------------------------------------ *
 * Page Callback
 * ------------------------------------------------------------------------ */

/**
 * Renders the basic display of the menu page for the theme.
 */
function cxt_plugin_page(  ) {

        // Get all options first
        $options = get_option( 'cxt_settings' );
        // Get the source taxonomy set in Settings
        $source_taxonomy_slug = $options['cxt_sourcetax'];
        $source_taxonomy_obj  = get_taxonomy( $source_taxonomy_slug );
        // Get current terms in the taxonomy
        $terms = get_terms( array(
            'taxonomy' => $source_taxonomy_slug,
            'hide_empty' => false,
        ) );


		?>

<div class="wrap">

    <h1>Context Term Tidier Plugin</h1>

    <div class="notice notice-info is-dismissible">
        <p>Source taxonomy: '<?php echo $source_taxonomy_obj->labels->singular_name; ?>'
            ('<?php echo $source_taxonomy_slug; ?>') set in Context Terms Tidier Settings [<a
                href="/wp-admin/options-general.php?page=magic-terms-settings">Change</a>]
            (<?php echo number_format(wp_count_terms( $source_taxonomy_slug )); ?> terms).</p>
    </div>

    <p>
        <!--This is the plugin page, cxt_plugin_page. Stuff goes here.-->
    </p>



    <?php
    			// settings_fields( 'pluginPage' );
    			// do_settings_sections( 'pluginPage' );
    			// submit_button();
    			?>

    <!-- https://stackoverflow.com/a/32340299/1375163 -->

    <!--
                <form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
                    <input type="hidden" name="action" value="magic-terms" />
                    <input type="submit" value="Do it!" class="button button-primary" />
                </form>
                -->

    <p>Clicking will attempt to determine what each term in the
        '<?php echo $source_taxonomy_obj->labels->singular_name; ?>' taxonomy may really be. If this can be determined,
        the term will be re-assigned to the taxonomies you specified in <a
            href="/wp-admin/options-general.php?page=magic-terms-settings">Context Terms Tidier Settings</a>. This will
        use <?php echo number_format(wp_count_terms( $source_taxonomy_slug )); ?> API calls from your Google Cloud
        account.</p>

    <!-- https://www.youtube.com/watch?v=7pO-FYVZv94 -->
    <form id="cxt-form" action="" method="POST">
        <div>
            <input type="submit" name="cxt-submit" id="cxt-submit"
                value="Tidy <?php echo number_format(wp_count_terms( $source_taxonomy_slug )); ?> Terms"
                class="button button-primary" />
            <img src="/wp-admin/images/wpspin_light.gif" class="waiting" id="cxt-loading" style="display:none">
        </div>
    </form>

    <p></p>

    <table id="cxt-old" class="widefat fixed">
        <thead>
            <tr>
                <th class="row-title"><?php echo $source_taxonomy_obj->labels->singular_name; ?> name</th>
                <th>Entity</th>
                <th>Target taxonomy</th>
            </tr>
        </thead>
        <tbody>
            <?php
                        $i = 0;
                        foreach ( $terms as $term ) {
                            // Limiter (since this uses credit card-linked API calls)
                            // if ($i < 5) {

                                $position = $i+1;

                                if($position % 2 == 0){
                                    $row_html = " class=\"alternate\"";
                                } else {
                                    $row_html = "";
                                }

                                ?>
            <tr<?php echo $row_html; ?>>
                <td><?php echo $term->name; ?></td>
                <td>-</td>
                <td>-</td>
                </tr>
                <?php
                            // }
                            $i++;
                        } ?>

        </tbody>
    </table>


    <div id="cxt-results">
    </div>

    <!--
                <script type="text/javascript">
                    $.ajax({
                        url:"ajax.php",
                        method:"GET",
                        success:function(data,status,xhr)
                        {
                            $("#cxt-results").html(data);
                        },
                        xhr: function(){
                            var xhr = $.ajaxSettings.xhr() ;

                            xhr.onprogress = function(evt){
                                $("#cxt-results").html(evt.currentTarget.responseText);
                            };

                            return xhr ;
                        }
                    });
                </script>
                -->


</div>

<?php

}



/* ------------------------------------------------------------------------ *
 * Ajax Enqueue
 * ------------------------------------------------------------------------ */
// Per https://www.youtube.com/watch?v=7pO-FYVZv94
function cxt_load_scripts($hook) {

    // Use settings above to know when we are on this settings page
    global $cxt_settings;

    if ( $hook != $cxt_settings )
        return;

    wp_enqueue_script( 'cxt-ajax', plugin_dir_url(__FILE__).'js/cxt-ajax.js', array('jquery') );
    wp_localize_Script('cxt-ajax', 'cxt_vars', array(
        'cxt_nonce'     => wp_create_nonce('cxt-nonce')
    ));

}
add_action('admin_enqueue_scripts', 'cxt_load_scripts');




/* ------------------------------------------------------------------------ *
 * Ajax Function
 * ------------------------------------------------------------------------ */

function cxt_process_ajax() {

    echo '<p>This response will be delivered by Ajax...</p>';

    // If neither of these verifies
    if (!isset($_POST['cxt_nonce']) || !wp_verify_nonce($_POST['cxt_nonce'], 'cxt-nonce') ) {
        die('Permissions check failed');
    }



    // Get taxonomy info from Settings
    $options = get_option( 'cxt_settings' );
    $source_taxonomy_slug = $options['cxt_sourcetax'];
    $source_taxonomy_obj  = get_taxonomy( $source_taxonomy_slug );


    $terms = get_terms( array(
        'taxonomy' => $source_taxonomy_slug,
        'hide_empty' => false,
    ) );
    ?>

<table class="widefat fixed">
    <thead>
        <tr>
            <th class="row-title"><?php echo $source_taxonomy_obj->labels->singular_name; ?> name</th>
            <th>Entity</th>
            <th>New taxonomy</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 0;
            foreach ( $terms as $term ) {
                // Limiter (since this uses credit card-linked API calls)
                if ($i < 10) {
                    // Google NLP's determination
                    $entity_name  = get_entity_type($term->name);
                    // Options field name for that entity type
                    $entity_field = 'cxt_goo_'.strtolower($entity_name);

                    $position = $i+1;

                    if($position % 2 == 0){
                        $row_html = " class=\"alternate\"";
                    } else {
                        $row_html = "";
                    }

                    ?>
        <tr<?php echo $row_html; ?>>
            <td><?php echo $term->name; ?></td>
            <td><?php echo $entity_name; ?></td>
            <td>
                <?php
                            // If any Target taxonomy for this Entity set in Settings
                            if ($options[$entity_field]) {
                                // Get the taxonomy object
                                $target_taxonomy_obj = get_taxonomy($options[$entity_field]);
                                // Show its friendly name
                                echo $target_taxonomy_obj->labels->singular_name;
                                // Show its slug
                                echo ' (' . $options[$entity_field] .')';
                                // Move term to this taxonomy!
                                echo 'Switch ' . $term->term_id . ' ' . $term->name . ' ' . $options[$entity_field];
                                switch_term_taxonomy( $term->term_id, $options[$entity_field] );
                            } else {
                                echo 'None';
                            }

                            // FIX TERM COUNT BLAH? - wp update term count?

                            ?>
            </td>
            </tr>
            <?php
                }
                $i++;
            } ?>

    </tbody>
</table>




<?php

    die();
}
add_action('wp_ajax_cxt_get_results', 'cxt_process_ajax');





/* ******************************************************************************************************************************************** */






    /* ########################################################################## *
     *
     *   DETERMINE ENTITY, via native wp_remote_post call
     *   cf. https://github.com/robertandrews/cxt-term-tidier/issues/1
     *   was via cURL, https://wordpress.stackexchange.com/questions/349271/how-to-convert-this-curl-to-wp-remote
     *
    /* ########################################################################## */

    function get_entity_type(
        $text_to_analyse,           // passed string to be handed to GClouD NLP
        $entity = 'type'            // part of each "entities" result to return
    ) {

        // Google Cloud API key
        $options = get_option( 'cxt_settings' );
        $google_nlp_api = $options['cxt_gcloud'];



        // Call the API endpoint, with API key
        $url = 'https://language.googleapis.com/v1/documents:analyzeEntities?key='.$google_nlp_api;

        // Request payload
        $payload = '{
          "document":{
            "type":"PLAIN_TEXT",
            "content":"'.$text_to_analyse.'"
          },
          "encodingType":"UTF8"
        }';


        // Call Goolge NLP API via wp_remote_post();
        // cf. https://wordpress.stackexchange.com/questions/349271/how-to-convert-this-curl-to-wp-remote?noredirect=1#comment510738_349271
        //
        $result_full = wp_remote_post(
            $url,
            array(
                'method'      => 'POST',
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(
                    'Content-Type' => 'application/json; charset=utf-8'
                ),
                'body'      =>  $payload,                       // Payload, text to analyse
                'data_format' => 'body'
            )
        );

        // Just the "body" bit
        $result_entities = $result_full['body'];

        // Store result in array
        $arr = json_decode($result_entities, true);

        // Pluck out the first value from the response object
        $ent_val = $arr['entities'][0][$entity];

        return $ent_val;

        // List of possible entities: https://cloud.google.com/natural-language/docs/reference/rest/v1/Entity#Type
        // UNKNOWN
        // PERSON
        // LOCATION
        // ORGANIZATION
        // EVENT
        // WORK_OF_ART
        // CONSUMER_GOOD
        // OTHER

    }





// New term created!
add_action( 'create_term', 'process_term', 11, 3 );

function process_term($term_id, $tt_id, $taxonomy) {


        // Get options
        $options = get_option( 'cxt_settings' );

        // If create_term allows - this seems nonsensical, just put the whole add_action in the clause?
        if ($options['cxt_alwayson'] == 1) {

            // # Only execute on new terms with source taxonomy
            if ($taxonomy == $options['cxt_sourcetax']) {

                // echo 'Term taxonomy is ' . $taxonomy . '<br>';
                // echo 'Source taxonomyis ' . $options['cxt_sourcetax'];


                // # Discover this term's entity
                // Get term's object
                $new_term = get_term($term_id, $taxonomy);
                // Ask Google: what is term's entity?
                $term_entity_type = get_entity_type($new_term->name);

                // # Map entity type to taxonomy
                if       ($term_entity_type == 'UNKNOWN') {
                    $new_tax_slug = $options['cxt_goo_unknown'];
                } elseif ($term_entity_type == 'PERSON') {
                    $new_tax_slug = $options['cxt_goo_person'];
                } elseif ($term_entity_type == 'LOCATION') {
                    $new_tax_slug = $options['cxt_goo_location'];
                } elseif ($term_entity_type == 'ORGANIZATION') {
                    $new_tax_slug = $options['cxt_goo_organization'];
                } elseif ($term_entity_type == 'EVENT') {
                    $new_tax_slug = $options['cxt_goo_event'];
                } elseif ($term_entity_type == 'WORK_OF_ART') {
                    $new_tax_slug = $options['cxt_goo_work_of_art'];
                } elseif ($term_entity_type == 'OTHER') {
                    $new_tax_slug = $options['cxt_goo_other'];
                } else {
                    // Do nothing
                }

                // # Re-assign term to new taxonomy
                if ($new_tax_slug) {
                    global $wpdb;
                    $update = $wpdb->update(
                        $wpdb->prefix . 'term_taxonomy',
                        [ 'taxonomy' => $new_tax_slug ],
                        [ 'term_taxonomy_id' => $term_id ],
                        [ '%s' ],
                        [ '%d' ]
                    );
                }
                // Switching taxonomy throws admin error notice


            }



        }




        // my_admin_notice();



}



/*
function my_admin_notice() {

    $screen = get_current_screen();

    print_r($screen);

}
*/





/*
// On form Submit
add_action( 'admin_action_magic-terms', 'my_admin_action' );
function my_admin_action()
{
    // Do your stuff here
    wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit();
}
*/










?>