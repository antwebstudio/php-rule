<?php

use Ant\Rule\AndOr\OrRule;

class OrRuleCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function testWhenOr(UnitTester $I) {
        $rule = OrRule::make()->when(true)->when(true);
        $I->assertTrue($rule->match());
        
        $rule = OrRule::make()->when(true)->when(false);
        $I->assertTrue($rule->match());
        
        $rule = OrRule::make()->when(false)->when(true);
        $I->assertTrue($rule->match());
        
        $rule = OrRule::make()->when(false)->when(false);
        $I->assertFalse($rule->match());
    }
}
