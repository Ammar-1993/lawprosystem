<?php

namespace Hesto\Core\Traits;


trait CanReplaceKeywords
{
    /**
     * Replace names with pattern.
     *
     * @param $stub
     * @return $this
     */
    public function replaceNames($template)
    {
        $name = $this->getParsedNameInput();

        $name = snake_case(camel_case(str_plural($name)));

        $plural = [
            '{{pluralCamel}}',
            '{{pluralSlug}}',
            '{{pluralSnake}}',
            '{{pluralClass}}',
        ];

        $singular = [
            '{{singularCamel}}',
            '{{singularSlug}}',
            '{{singularSnake}}',
            '{{singularClass}}',
        ];

        $replacePlural = [
            camel_case($name),
            str_slug($name),
            snake_case($name),
            ucfirst(camel_case($name)),
        ];

        $replaceSingular = [
            str_singular(camel_case($name)),
            str_singular(str_slug($name)),
            str_singular(snake_case($name)),
            str_singular(ucfirst(camel_case($name))),
        ];



        $template = str_replace($plural, $replacePlural, $template);
        $template = str_replace($singular, $replaceSingular, $template);
        $template = str_replace('{{Class}}', ucfirst(camel_case($name)), $template);

        return $template;
    }
}
