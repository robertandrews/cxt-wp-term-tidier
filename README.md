# Context Term Tidier

Many WordPress installs suffer from cramming hundreds or thousands of varied taxonomy terms in to a limited number of ill-suited, all-purpose taxonomies (eg. the default "categories" and "tags").

These are better off split in to dedicated taxonomies. For example, storing "Bill Gates" and "Microsoft" terms in "tags" is not optimal, because one is a *person* whilst the other is a *company*.

There is no straightforward way to split up existing taxonomies more granularly in this way, except for  labour-intensive and manual, technical effort. So, many WordPress installs continue to suffer from not having created granular taxonomies intentionally at the outset.

Term Tidier tidies up messy taxonomies like these automatically. It uses natural language processing and knowledge graph technology to determine the real <a href="https://gcloud.readthedocs.io/en/latest/_modules/google/cloud/language/entity.html#EntityType">entity type</a> of existing terms, then re-assigns them each to a more appropriate, alternative taxonomy.

## How it works

Term Tidier uses Google Cloud's Natural Language Processing features via API calls.

Users set a "source taxonomy", the taxonomy they want to be tidied up.

For each term within that taxonomy, Term Tidier calls Google Cloud to examine the term name, aiming to return a determination as to its true "entity".

The plugin receives one of eight "entity" type determinations from Google Cloud - UNKNOWN, PERSON, LOCATION, ORGANIZATION, EVENT, WORK_OF_ART, CONSUMER_GOOD or OTHER.

For each entity type, users specify a target taxonomy to which a matching term will be moved. For example, you can map all terms found to be a "LOCATION" to your own "Places" taxonomy, if it exists.

For each term in the source taxonomy, if a particular entity was determined, Term Tidier moves the term to your corresponding taxonomy.

## Installation

Term Tidier is a WordPress plugin. Upload the `cxt-term-tidier` folder to `wp-content/plugins/` or through the WordPress admin's plugin uploader.

## Settings

Term Tidier settings must be set in the WordPress admin, via the page at "Settings > Context Term Tidier".

### Google Cloud API key

Term Tidier is powered by Google Cloud Natural Language. You need an account. Follow the instructions in Settings to create an account, then copy and paste your API key in to Settings.

Google Cloud currently provides up to 5,000 monthly API calls for free. That means you can tidy 5,000 WordPress taxonomy terms per month for free. Higher usage than this may incur billing.

### Source taxonomy

Select the taxonomy you want to examine and tidy up in the dropdown.

### Re-assign terms

Select a target taxonomy to which terms to be of a particular entity type (UNKNOWN, PERSON, LOCATION, ORGANIZATION, EVENT, WORK_OF_ART, CONSUMER_GOOD or OTHER) will be moved

### Usage

Use Term Tidier from the WordPress Tools menu (Tools > Context Term Tidier).

The plugin page confirms your settings as set in Settings, displaying the taxonomy and terms which will be examined.

Click the "Tidy Terms" button to execute the operation.

Term Tidier will cycle through each term, seeking an "entity" determination and re-assigning any terms possible.
