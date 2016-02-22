<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Element\NodeElement;
use Behat\Behat\Context\Context;
//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
	protected $session, $driver, $url;
	protected $adminpage='http://10.122.6.17:8090/repurposing-tool/web/app_dev.php/dashboard';
	protected $userpage='http://10.122.6.17:8090/repurposing-tool/web/app_dev.php/user/dashboard';
	
    public function __construct($baseUrl)
    {
        $this->url= $baseUrl;
		$this->driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
		$this->session = new \Behat\Mink\Session($this->driver);
		$this->session->start();
    }

/**
     * @Given /^I am on rtool login page$/
     */
    public function iAmOnRtoolLoginPage()
    {
        $this->session->visit($this->url);
    }

    /**
     * @Then /^I enter username "([^"]*)"$/
     */
    public function iEnterUsername($name)
    {
       $username = $this->session->getPage()->findField('_username');
	   $username->setValue($name);
    }

    /**
     * @Given /^I enter Password "([^"]*)"$/
     */
    public function iEnterPassword($pwd)
    {
       $password = $this->session->getPage()->findField('_password');
	   $password->setValue($pwd);
    }

    /**
     * @When /^I click on Login button$/
     */
    public function iClickOnLoginButton()
    {
        $loginbutton = $this->session->getPage()->findButton('LOGIN');
		$loginbutton->click();
    }

    /**
     * @Then /^I see the page "([^"]*)"$/
     */
    public function iSeeThePage($page)
    {
       $currentpage = $this->session->getCurrentUrl();
	  if($page==='Admin Dashboard')
	  {
		  if($currentpage!==$this->adminpage)
		  {
			throw new \InvalidArgumentException(sprintf('access to incorrect page is given'));
		  }
	  }
	  else if($page === 'User Dashboard')
	  {
		   if($currentpage!==$this->userpage)
		  {
			throw new \InvalidArgumentException(sprintf('access to incorrect page is given'));
		  }
	  }
    }

    /**
     * @Then /^I log out$/
     */
    public function iLogOut()
    {
        $name= $this->session->getPage()->find('xpath','.//*[@id="wrapper"]/nav/ul/li[5]/a');
		if ($name !== null)
		{
			$name->click();
		}
		$logoutbutton= $this->session->getPage()->find('xpath','.//*[@id="wrapper"]/nav/ul/li[5]/ul/li[4]/a');
		$logoutbutton->Click();
		
    }

    /**
     * @Then /^I close the browser$/
     */
    public function iCloseTheBrowser()
    {
         $this->session->stop();
    }

    /**
     * @Then /^I See errormessage "([^"]*)"$/
     */
    public function iSeeErrormessage($message)
    {
        if($message=== "Username is mandatory")
	   {
	     $username = $this->session->getPage()->findField('_username');
		 $displaymessage = $username->getAttribute('placeholder');
		 
		if($displaymessage !== $message || $displaymessage ===null)
		{
			throw new \InvalidArgumentException(sprintf('Could not find error message'));
		}
	   }
	   if($message=== "Password is mandatory" )
	   {
		 
	     $password = $this->session->getPage()->findField('_password');
		 $displaymessage = $password->getAttribute('placeholder');
		 
		if($displaymessage !== $message || $displaymessage ===null)
		{
			throw new \InvalidArgumentException(sprintf('Could not find error message'));
		}
	   }
	   if($message=== "Incorrect Username Password Combination")
	   {
		 $errorbox = $this->session->getPage()->find('xpath','.//*[@id="messages_box"]');
		 if($errorbox === null)
		 {
			 throw new \InvalidArgumentException(sprintf('Could not find element'));
		 }
	   }
    }

}
