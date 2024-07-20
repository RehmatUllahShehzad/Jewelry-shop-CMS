<?php

namespace App\Traits;

use DOMDocument;
use LaraEditor\App\Contracts\Editable;

trait EditorPlaceholders
{
    public function setPlaceholders(Editable $editable): void
    {
        $path = 'frontend.placeholders';

        $re = '/\[\[[A-Z][a-z]*(-[A-Z][a-z]*)*([\s]+[a-z]+(=[^]]+)?)*\]\]/';

        preg_match_all($re, $editable->html, $placeholders);

        $placeholders = $placeholders[0] ?? [];

        foreach ($placeholders as $_placeholder) {
            /** @var string */
            $placeholder = str_replace(['[[', ']]'], '', $_placeholder);

            $attributes = $this->getPlaceholderAttributes($placeholder);
            $attributes['item'] = $editable;

            /** @var array<mixed> */
            $view = preg_split('/[\s]+/', $placeholder);

            /** @var string */
            $view = array_shift($view);
            $view = strtolower($view);

            /**
             * @var view-string
             */
            $viewPath = "{$path}.{$view}";

            if (view()->exists($viewPath)) {
                $editable->setPlaceholder($_placeholder, view($viewPath, $attributes)->render());
            }
        }
    }

    /**
     * @param  string  $placeholder
     * @return array<mixed>
     */
    protected function getPlaceholderAttributes($placeholder)
    {
        $attributes = [];

        try {
            $placeholder = html_entity_decode($placeholder);

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML("<$placeholder />");
            libxml_use_internal_errors(false);

            $body = $dom->documentElement->firstChild;
            $placeholder = $body->childNodes[0];
            $length = $placeholder->attributes->length;

            for ($i = 0; $i < $length; $i++) {
                $name = $placeholder->attributes->item($i)->name;
                $value = $placeholder->getAttribute($name);

                $attributes[$name] = (empty($value) || $value == "''") ? true : $value;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $attributes;
    }
}
