<?php

namespace LaraEditor\App\Editor;

use LaraEditor\App\Contracts\Editable;

class EditorFactory extends EditorBaseClass
{
    public function initialize(Editable $editable)
    {
        $assetRepository = app(AssetRepository::class);
        $editorCanvas = new EditorCanvas;
        $editorCanvas->styles = array_merge(
            config('laraeditor.styles'),
            $editable->getStyleSheetLinks()
        );

        $editorCanvas->scripts = array_merge(
            config('laraeditor.scripts'),
            $editable->getScriptLinks()
        );

        $editorStorage = new EditorStorageManager;
        $editorStorage->type = 'remote';
        $editorStorage->urlStore = $editable->getEditorStoreUrl();
        $editorStorage->options = [
            'remote' => [
                'fetchOptions' => [
                    'headers' => [
                        'X-CSRF-TOKEN' => csrf_token(),
                    ],
                ],
            ],
        ];

        $editorAssetManager = new EditorAssetManager;
        $editorAssetManager->assets = $assetRepository->getAllMediaLinks();
        $editorAssetManager->upload = $assetRepository->getUploadUrl();
        $editorAssetManager->headers = [
            '_token' => csrf_token(),
        ];

        $editorAssetManager->uploadName = 'file';
        $editorConfig = new EditorConfig;
        $editorConfig->projectData = [
            'pages' => [
                $editable->getPage(),
            ],
            'styles' => $editable->getStyles(),
        ];
        $editorConfig->canvas = $editorCanvas;
        $editorConfig->assetManager = $editorAssetManager;
        $editorConfig->storageManager = $editorStorage;
        $editorConfig->forceClass = config('laraeditor.force_class', true);
        $editorConfig->avoidInlineStyle = true;
        $editorConfig->templatesUrl = $editable->getEditorTemplatesUrl();
        $editorConfig->assetStoreUrl = $assetRepository->getUploadUrl();
        $editorConfig->filemanagerUrl = $assetRepository->getFileManagerUrl();
        $editorConfig->_token = csrf_token();
        $editorConfig->editor_icons = config('laraeditor.assets.editor_icons');
        $editorConfig->media_proxy_url = config('laraeditor.assets.proxy_url') ?? route('laraeditor.asset.proxy_url');
        $editorConfig->media_proxy_url_input = config('laraeditor.assets.proxy_url_input');

        return $editorConfig;
    }
}
