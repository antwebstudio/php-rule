<?php
namespace Ant\Rule\AndOr;

class OrRule extends \Ant\Rule\Rule {
	public function match($rulesContext = []) {
		$this->prepare();
		
		foreach ((array) $this->rules as $rule) {
            if ($rule === true) return true;

            if ($rule !== false) {   
                if (is_callable($rule)) {
                    $value = call_user_func_array($rule, []);
                    if ($value) {
                        return true;
                    }
                } else if (!is_object($rule)) {
                    $rule = $this->instantiateRule($rule, $this);
                
                    if ($rule->match($rulesContext)) {
                        return true;
                    }
                }
            }
		}
		
		// If all rules matched
		return false;
	}
}