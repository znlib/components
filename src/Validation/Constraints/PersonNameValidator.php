<?php

namespace ZnLib\Components\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use ZnDomain\Validator\Constraints\BaseValidator;

class PersonNameValidator extends BaseValidator
{

    protected $constraintClass = PersonName::class;

    public function validate($value, Constraint $constraint)
    {
        $this->checkConstraintType($constraint);
        if ($this->isEmptyStringOrNull($value)) {
            return;
        }

        //$chars = preg_quote('!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~');

        $isValid = preg_match('/^([^\s\d]+)$/i', $value);
        if (!$isValid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
