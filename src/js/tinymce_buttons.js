(function() {
    tinymce.PluginManager.add('mybutton', function( editor, url ) {
        editor.addButton( 'mybutton', {
            text: tinyMCE_object.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: tinyMCE_object.button_title,
                    body: [
                        {
                            type: 'textbox',
                            name: 'img',
                            label: tinyMCE_object.image_title,
                            value: '',
                            classes: 'my_input_image',
                        },
                        {
                            type: 'button',
                            name: 'my_upload_button',
                            label: '',
                            text: tinyMCE_object.image_button_title,
                            classes: 'my_upload_button',
                        },
                        {
                            type   : 'textbox',
                            name   : 'heading',
                            label  : 'Baner heading',
                        },
                        {
                            type   : 'textbox',
                            name   : 'link',
                            label  : 'Baner link',
                        },
                        {
                            type   : 'textbox',
                            name   : 'description',
                            label  : 'Baner description',
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[banner src="' + e.data.img + '" title="' + e.data.heading + '" link="' + e.data.link +'" desc="' + e.data.description + '"]');
                    }
                });
            },
        });
    });
 
})();