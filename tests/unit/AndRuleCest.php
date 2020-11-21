<?php 
use Ant\Rule\Rule;

class AndRuleCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function testWhenAnd(UnitTester $I) {
        $rule = Rule::make()->when(true)->when(true);
        $I->assertTrue($rule->match());
        
        $rule = Rule::make()->when(true)->when(false);
        $I->assertFalse($rule->match());
        
        $rule = Rule::make()->when(false)->when(true);
        $I->assertFalse($rule->match());
        
        $rule = Rule::make()->when(false)->when(false);
        $I->assertFalse($rule->match());
    }
}
