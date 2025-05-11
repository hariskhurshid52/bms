MINI_LOADER_HTML = `<div class="d-flex justify-content-center">  <div class="spinner-border" role="status"></div>   </div>`
initEmailTemplateEditor = (selector,options={}) => {
    tinymce.init({
        selector: selector,
        height: 500,
        branding: false,
        menubar: true,
        autosave_interval: '30s',
        ...options,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table',  'wordcount'
        ],
        contextmenu: 'link image inserttable | cell row column deletetable',
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | code | preview',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif,Nunito; font-size:16px }',
        style_formats: [
            { title: 'Headers', items: [
                    { title: 'Header 1', format: 'h1' },
                    { title: 'Header 2', format: 'h2' },
                    { title: 'Header 3', format: 'h3' }
                ] },
            { title: 'Inline', items: [
                    { title: 'Bold', icon: 'bold', format: 'bold' },
                    { title: 'Italic', icon: 'italic', format: 'italic' },
                    { title: 'Underline', icon: 'underline', format: 'underline' },
                    { title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough' }
                ] },
            { title: 'Blocks', items: [
                    { title: 'Paragraph', format: 'p' },
                    { title: 'Blockquote', format: 'blockquote' },
                    { title: 'Div', format: 'div' },
                    { title: 'Pre', format: 'pre' }
                ] }
        ],
        content_css: [
            `${window.location.origin}/assets/css/style.css`
        ],
        setup: function (editor) {
            editor.on('submit', function (e) {
                const content = editor.getContent().replace(/(&nbsp;){2,}/g, ' ');
                editor.setContent(content);
            });
        }
    });
}