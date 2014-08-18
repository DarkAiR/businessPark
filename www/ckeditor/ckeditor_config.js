CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    config.language = 'ru';
    // config.uiColor = '#AADC6E';
    config.skin = 'moono-light';
    config.contentsCss = '/ckeditor/css/ckeditor.css';
};

CKEDITOR.config.forcePasteAsPlainText = true;
CKEDITOR.config.pasteFromWordRemoveStyles = true;
CKEDITOR.config.pasteFromWordRemoveFontStyles = true;

// Block all custom styles in CKEditor
CKEDITOR.addStylesSet( 'default', [
]);