/**
 * Block
 */
( function( blocks, i18n, element, editor) {
	var el = element.createElement;
    var __ = i18n.__;
    var PlainText = editor.PlainText;

	var blockStyle = {
		backgroundColor: '#900',
		color: '#fff',
		padding: '20px',
	};

	blocks.registerBlockType( 'php-everywhere-block/php', {
		title: __( 'PHP Everywhere', 'php-everywhere' ),
		icon: 'editor-code',
		category: 'formatting',
		attributes: {
			code: {
				type: 'string',
			}
		},
		edit: function( props ) {
			try {
				var content = decodeURIComponent(atob(props.attributes.code));
			}
			catch(e)
			{
				var content = "";
			}
			function onChangeContent( newContent ) {
				newContent = btoa(encodeURIComponent(newContent));
				props.setAttributes( { code: newContent } );
			}

			return el(
				PlainText,
				{
					tagName: 'p',
					className: props.className,
					onChange: onChangeContent,
					placeholder: __( 'Put your PHP code here.' ),
					value: content,
				}
			);
		},
		save: function( properties ) {
			return null;
		},
	} );
}(
	window.wp.blocks,
	window.wp.i18n,
    window.wp.element,
    window.wp.editor
) );