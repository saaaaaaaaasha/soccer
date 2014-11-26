CKEDITOR.plugins.add('pagecut', {
      init: function( editor )
    {            

            editor.addCommand('insertPagecut',
            {
                exec: function( editor )
                {                  
                  editor.insertHtml('&lt;!--cut--&gt;');
                }
            });

            editor.ui.addButton('Pagecut',
            {
                label: 'Вставить кат',
                command: 'insertPagecut',
                icon: this.path + 'images/icon.png'
            } );
    }
});