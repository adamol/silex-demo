<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Snippet\Appender\SnippetAppender;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $app;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $app = require __DIR__.'/../../src/app.php';
        require __DIR__.'/../../tests/config/factories.php';
        $this->app = $app;
    }

    public function setUp()
    {
        $this->app['db_manager']->resetAllIncrements();
        $this->app['db']->beginTransaction();
    }

    public function tearDown()
    {
        $this->app['db']->rollBack();
    }

    /**
     * @Given there are :amount books in the system
     */
    public function thereAreBooksInTheSystem($amount)
    {
        $this->app['factories.books']->create($amount);
    }

    /**
     * @Given the books with id :ids are of category :categoryType
     */
    public function theBooksWithIdAreOfCategory($ids, $categoryType)
    {
        $idsList = explode(',', $ids);

        foreach ($idsList as $id) {
            $this->app['factories.books']->setCategoryForBook($id, $categoryType);
        }
    }

    /**
     * @When I send a :arg1 request to :arg2
     */
    public function iSendARequestTo($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see :arg1 books
     */
    public function iShouldSeeBooks($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the response contains json:
     */
    public function theResponseContainsJson(PyStringNode $string)
    {
        throw new PendingException();
    }
}
