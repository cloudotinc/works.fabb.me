( function( api ) {

	// Extends our custom "ember" section.
	api.sectionConstructor['juniper'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
