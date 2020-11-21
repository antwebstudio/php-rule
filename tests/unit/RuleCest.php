<?php
use Ant\Rule\Rule;

class RuleCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function testWhenBoolean(UnitTester $I)
    {
        $rule = Rule::make()->when(true);
        $I->assertTrue($rule->match());
    }

    public function testWhenCallable(UnitTester $I) {
        $rule = Rule::make()->when(function() {
            return true;
        });
        $I->assertTrue($rule->match());

        $rule = Rule::make()->when(function() {
            return false;
        });
        $I->assertFalse($rule->match());
    }

    public function testWhenRule(UnitTester $I) {
        $trueRule = Rule::make()->when(true);
        $falseRule = Rule::make()->when(false);

        $rule = Rule::make()->when($trueRule);
        $I->assertTrue($rule->match());

        $rule = Rule::make()->when($falseRule);
        $I->assertFalse($rule->match());
    }
}