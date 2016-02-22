Feature: Login rTool

@rTool_Successful_login_admin
	Scenario: Successful Login rTool for Admin
        Given I am on rtool login page
        Then I enter username "admin"
		And I enter Password "test"
		When I click on Login button
		Then I see the page "Admin Dashboard"
		Then I log out
		Then I close the browser
		
@rTool_Successful_login_user
	Scenario: Successful Login rTool for User
        Given I am on rtool login page
        Then I enter username "user"
		And I enter Password "test"
		When I click on Login button
		Then I see the page "User Dashboard"
		Then I log out
	    Then I close the browser

@rTool_Login_Validations_Blank_username_and_Password
	Scenario: rTool_login_PageValidations
        Given I am on rtool login page
        Then I enter username ""
		And I enter Password ""
		When I click on Login button
		Then I See errormessage "Username is mandatory"
		Then I See errormessage "Password is mandatory"
		Then I close the browser

@rTool_Login_Validations_InvalidUserNameorPassword
	Scenario: rTool_login_PageValidations
        Given I am on rtool login page
        Then I enter username "admin"
		And I enter Password "123434"
		When I click on Login button
		Then I See errormessage "Incorrect Username Password Combination"
		Then I close the browser