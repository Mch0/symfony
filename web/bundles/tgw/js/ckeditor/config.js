/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {

    var envs = window.location.pathname.match(/\/app[_a-z]*\.php\//);
    if (envs !== null && envs.length === 1)
    {
        env = envs[0];
    }
    else
    {
        env = '/';
    }

    config.filebrowserBrowseUrl = env + 'kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = env + 'kcfinder/browse.php?type=images';
    config.filebrowserUploadUrl = env + 'kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = env + 'kcfinder/upload.php?type=images';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
