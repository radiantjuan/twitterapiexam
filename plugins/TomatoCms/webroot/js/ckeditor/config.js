/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    //config.removeButtons = 'Underline,Subscript,Superscript,Source';
    //config.removeButtons = 'Underline,Subscript,Superscript';

    // Set the most common block elements.
    config.format_tags = 'p;h1;h2;h3;h4;pre';

    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';

    //config.removePlugins: 'sourcearea',
    //config.startupMode = 'source';

    config.allowedContent = true;
    config.extraAllowedContent = 'div(*)';
    config.extraAllowedContent = 'a(*)';
    config.extraAllowedContent = 'span(*)';
    config.extraAllowedContent = 'i(*)';
    config.extraAllowedContent = '*(*)';

    config.protectedSource.push(/<i[^>]*><\/i>/g);

    config.autoParagraph = false;

    // Enable Color Button
    config.extraPlugins = 'floatpanel,colordialog,colorbutton';
    config.colorButton_enableMore = true;

    config.filebrowserBrowseUrl = TomatoCms.basePath + 'admin/media_upload/browse';
    config.image_previewText = ' ';

    config.fillEmptyBlocks = false;

    config.extraPlugins = 'autogrow';
    config.autoGrow_minHeight = 400;
    config.autoGrow_maxHeight = 600;

};
