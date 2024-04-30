<?php
require_once 'component.php';

class View
{
    private string $title;
    private Component $header;
    private Component $main;
    private Component $footer;
    private Component $doctype;
    private Component $html;

    public function __construct(string $title = 'Título de la vista')
    {
        $this->title = $title;
        $this->header = new Component('header');
        $this->main = new Component('main');
        $this->footer = new Component('footer');
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setHeaderTitle(string $headerTitle)
    {
        $this->header->addSubComponent('h1', new Component('h1', [], $headerTitle));
    }

    public function setHeaderSubTitle(string $headerSubTitle)
    {
        $this->header->addSubComponent('h2', new Component('h2', [], $headerSubTitle));
    
    }

    public function build()
    {
        $this->doctype = new Component(
            '!DOCTYPE',
            [
                'noName' => 'html'
            ]
        );

        $this->html = new Component(
            'html',
            [
                'lang' => 'es'
            ]
        );

        $this->html->addSubComponent(
            'head',
            new Component(
                'head'
            )
        );

        $this->html->getSubComponent(
            'head'
        )->addSubComponent(
            'metaCharSet',
            new Component(
                'meta',
                [
                    'charset' => 'UTF-8'
                ]
            )
        );

        $this->html->getSubComponent(
            'head'
        )->addSubComponent(
            'metaNameContent',
            new Component(
                'meta',
                [
                    'name' => 'viewport',
                    'content' => 'width=device-width, initial-scale=1.0'
                ]
            )
        );

        $this->html->getSubComponent(
            'head'
        )->addSubComponent(
            'title',
            new Component(
                'title',
                [],
                $this->title
            )
        );

        $this->html->addSubComponent(
            'body',
            new Component(
                'body'
            )
        );

        $this->html->getSubComponent(
            'body'
        )->addSubComponent(
            'header',
            $this->header
        );

        $this->html->getSubComponent(
            'body'
        )->addSubComponent(
            'main',
            $this->main
        );

        $this->html->getSubComponent(
            'body'
        )->addSubComponent(
            'footer',
            $this->footer
        );

        $this->doctype->build();
        $this->html->build();
    }

    public function show()
    {
        echo $this->doctype->getHtml() . $this->html->getHtml();
    }
}
