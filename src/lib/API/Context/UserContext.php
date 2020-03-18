<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\Behat\API\Context;

use Behat\Behat\Context\Context;
use EzSystems\Behat\API\Facade\UserFacade;
use EzSystems\Behat\Core\Behat\ArgumentParser;
use Behat\Gherkin\Node\TableNode;

class UserContext implements Context
{
    /** @var \EzSystems\Behat\API\Facade\UserFacade */
    private $userFacade;

    /** @var \EzSystems\Behat\Core\Behat\ArgumentParser */
    private $argumentParser;

    public function __construct(UserFacade $userFacade, ArgumentParser $argumentParser)
    {
        $this->userFacade = $userFacade;
        $this->argumentParser = $argumentParser;
    }

    /**
     * @Given I create a user group :userGroupName
     */
    public function createUseGroup(string $userGroupName): void
    {
        $this->userFacade->createUserGroup($userGroupName);
    }

    /**
     * @Given I create a user :userName with last name :userLastName
     * @Given I create a user :userName with last name :userLastName in group :userGroupName
     */
    public function createUserInGroup(string $userName, string $userLastName, string $userGroupName = null): void
    {
        $this->userFacade->createUser($userName, $userLastName, $userGroupName);
    }

    /**
     * @Given I assign user :userName to role :roleName
     */
    public function assignUserToRole(string $userName, string $roleName): void
    {
        $this->userFacade->assignUserToRole($userName, $roleName);
    }

    /**
     * @Given I assign user group :groupName to role :roleName
     * @Given I assign user group :groupName to role :roleName with limitations:
     */
    public function assignUserGroupToRole(string $userGroupName, string $roleName, TableNode $limitationData = null): void
    {
        $parsedLimitations = $limitationData === null ? null : $this->argumentParser->parseLimitations($limitationData);

        if (is_array($parsedLimitations) && count($parsedLimitations) > 1) {
            throw new \Exception('Passed more than one Role assignment limitation!');
        }

        $roleLimitation = $parsedLimitations[0];

        $this->userFacade->assignUserGroupToRole($userGroupName, $roleName, $roleLimitation);
    }
}
