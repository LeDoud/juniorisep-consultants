<?php

/*
 * Location of where the uploads should be.
 * REQUIRED
 */
$config['upload_path'] = './tmp/';

/*
 * The allowed file types to be uploaded.
 * REQUIRED
 */
$config['allowed_types'] = '';

/* Ajouts custom */

$config['allowed_types'] = 'pdf|zip';
$config['max_size'] = '10000';
