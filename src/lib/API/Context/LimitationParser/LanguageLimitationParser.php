<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\Behat\API\Context\LimitationParser;

use eZ\Publish\API\Repository\Values\User\Limitation;
use eZ\Publish\API\Repository\Values\User\Limitation\LanguageLimitation;

class LanguageLimitationParser implements LimitationParserInterface
{
    public function supports(string $limitationType): bool
    {
        return $limitationType === Limitation::LANGUAGE;
    }

    public function parse(string $limitationValues): Limitation
    {
        return new LanguageLimitation(
            ['limitationValues' => explode(',', $limitationValues)]
        );
    }
}
