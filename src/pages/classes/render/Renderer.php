<?php
declare(strict_types=1);

namespace iutnc\touiter\render;

interface Renderer
{
    public function render(?int $selector = null) : string;
}