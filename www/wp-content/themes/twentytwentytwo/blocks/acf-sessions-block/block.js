( function ( blocks, element, serverSideRender ) {
   var el = element.createElement,
      registerBlockType = blocks.registerBlockType,
      ServerSideRender = serverSideRender;

   registerBlockType('custom/acf-sessions-block', {

      title: 'Sessions List',
      icon: 'list-view', // WP Dashicons
      category: 'common',

      edit: function() {
         return el(
            'div',
            null,
            el( ServerSideRender, {
                 block: 'custom/acf-sessions-block'
            } )
         );
      }
   });
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.serverSideRender
);