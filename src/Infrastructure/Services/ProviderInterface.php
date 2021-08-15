<?php

namespace Test\Infrastructure\Services;

interface ProviderInterface
{
    public function getContent(array $criteria);
}
