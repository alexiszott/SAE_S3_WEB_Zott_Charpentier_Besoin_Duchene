<?php

namespace iutnc\touiter\render;

interface Renderer
{
    public function render(int $selector) : string;
}