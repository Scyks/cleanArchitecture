Feature: createTodo
	As a user i want to be able to create a new todo
	item.

	Scenario Outline:
		Given I create a "CreateTodo" Request
		And I fill in "<name>" as "name"
		And I fill in <priority> as "priority"
		And I fill in <done> as "done"
		And I fill in DateTime "<startDate>" as "startDate"
		And I fill in DateTime "<endDate>" as "endDate"
		When I create and recieve this todo
		Then I should have "<name>" as "name"
		And I should have "<priority>" as "priority"
		And I should have <done> as done
		And I should have DateTime "<startDate>" as "startDate"
		And I should have DateTime "<endDate>" as "endDate"

	Examples:
	| name | priority | done | startDate | endDate |
	| Foobar | 2 | true | | |
	| Foobar | 4 | false | 2012-05-09 | |
	| Foobar | 4 | false | 2012-05-09 | 2013-05-09 |
	| Foobar | 4 | true | 2012-05-09 | 2013-05-09 |
