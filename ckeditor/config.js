CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'MyToolbar';
	config.language = 'fr';
	config.toolbar_MyToolbar =
	[
		[ 'Preview', 'Paste','PasteText','PasteFromWord','-','Undo','Redo', 'Image','Flash','Table','HorizontalRule','SpecialChar', 
		'Bold','Italic','Strike','-','RemoveFormat', 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote', 'Link' ]
	];
};