if ( window.CKEDITOR )
{
	(function()
	{
		var showCompatibilityMsg = function()
		{
			var env = CKEDITOR.env;

			var html = '<p><strong>Votre navigateur n\'est pas compatible avec cette page...</strong>';

			var browsers =
			{
				gecko : 'Firefox 2.0',
				ie : 'Internet Explorer 6.0',
				opera : 'Opera 9.5',
				webkit : 'Safari 3.0'
			};

			var alsoBrowsers = '';

			for ( var key in env )
			{
				if ( browsers[ key ] )
				{
					if ( env[key] )
						html += ' Cette page est compatible avec ' + browsers[ key ] + ' ou plus élevé.';
					else
						alsoBrowsers += browsers[ key ] + '+, ';
				}
			}

			alsoBrowsers = alsoBrowsers.replace( /\+,([^,]+), $/, '+ and $1' );

			html += ' Elle est également compatible avec ' + alsoBrowsers + '.';

			html += '</p><p>Avec votre navigateur, vous pouvez seulement voir ou éditer la source (HTML) dans un champ de texte. Vous ne pouvez pas accéder à l\'interface graphique !</p>';

			var alertsEl = document.getElementById( 'alerts' );
			alertsEl && ( alertsEl.innerHTML = html );
		};

		var onload = function()
		{
			// Show a friendly compatibility message as soon as the page is loaded,
			// for those browsers that are not compatible with CKEditor.
			if ( !CKEDITOR.env.isCompatible )
				showCompatibilityMsg();
		};

		// Register the onload listener.
		if ( window.addEventListener )
			window.addEventListener( 'load', onload, false );
		else if ( window.attachEvent )
			window.attachEvent( 'onload', onload );
	})();
}
