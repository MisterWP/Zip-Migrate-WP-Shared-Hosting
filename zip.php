<?php

/*
 ZIP the /wp-content/ directory from the root folder.
 Just put it in your root directory, go to example.com/zip.php, wget from your new server and unzip inside your new wp-content.
 The other files have to be get in a freshely downloaded WordPress release. 
*/
 
/* ZIP File name and path */
$zip_file = 'wp-content.zip';
 
/* Exclude Files */
$exclude_files = array();
$exclude_files[] = realpath( $zip_file );
$exclude_files[] = realpath( 'zip.php' );
 
/* Path of current folder, need empty or null param for current folder */
$root_path = realpath( 'wp-content' );
 
/* Initialize archive object */
$zip = new ZipArchive;
$zip_open = $zip->open( $zip_file, ZipArchive::CREATE );
 
/* Create recursive files list */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator( $root_path ),
    RecursiveIteratorIterator::LEAVES_ONLY
);
 
/* For each files, get each path and add it in zip */
if( !empty( $files ) ){
 
    foreach( $files as $name => $file ) {
 
        /* get path of the file */
        $file_path = $file->getRealPath();
 
        /* only if it's a file and not directory, and not excluded. */
        if( !is_dir( $file_path ) && !in_array( $file_path, $exclude_files ) ){
 
            /* get relative path */
            $file_relative_path = str_replace( $root_path, '', $file_path );
 
            /* Add file to zip archive */
            $zip_addfile = $zip->addFile( $file_path, $file_relative_path );
        }
    }
}
 
/* Create ZIP after closing the object. */
$zip_close = $zip->close();
  
  
?>
