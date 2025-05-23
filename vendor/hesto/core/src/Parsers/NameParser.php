<?php

namespace Hesto\Core\Parsers;


class NameParser
{
    protected $name;

    protected $text;

    protected $singular = [
        '{{singularCamel}}',
        '{{singularSlug}}',
        '{{singularSnake}}',
        '{{singularClass}}',
    ];

    protected $plural = [
        '{{pluralCamel}}',
        '{{pluralSlug}}',
        '{{pluralSnake}}',
        '{{pluralClass}}',
    ];

    protected $special = [

    ];



    /**
     * Replace names with pattern.
     *
     * @param $stub
     * @return $this
     */
    public function replace($template)
    {
        $this->name = $this->getParsedNameInput();

        $replacePlural = [
            camel_case($this->name),
            str_slug($this->name),
            snake_case($this->name),
            ucfirst(camel_case($this->name)),
        ];

        $replaceSingular = [
            str_singular(camel_case($this->name)),
            str_singular(str_slug($this->name)),
            str_singular(snake_case($this->name)),
            str_singular(ucfirst(camel_case($this->name))),
        ];


        $template = str_replace($this->plural, $replacePlural, $template);
        $template = str_replace($this->singular, $replaceSingular, $template);
        $template = str_replace('{{Class}}', ucfirst(camel_case($this->name)), $template);

        return $template;
    }
}
