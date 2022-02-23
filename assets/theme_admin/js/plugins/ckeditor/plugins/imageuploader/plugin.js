// Copyright (c) 2015, Fujana Solutions - Moritz Maleck. All rights reserved.
// For licensing, see LICENSE.md

CKEDITOR.plugins.add( 'imageuploader', {
    init: function( editor ) {
        editor.config.filebrowserBrowseUrl = '../assets/theme_admin/js/plugins/ckeditor/plugins/imageuploader/imgbrowser.php';
    }
});
