<?php

namespace iutnc\touiter\render;

interface Renderer
{
    const LONG = 2;
    const COURT = 1;
    public function render(int $selector): string;
}