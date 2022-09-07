<?php

namespace App\Request;

use App\Exception\BusinessException;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class RequestValidation implements ServiceSubscriberInterface
{
    /** @var Request|null */
    protected $request;

    /** @var ContainerInterface */
    protected $container;

    /**
     * auto call
     * @see RequestValidatorTriggerListener
     */
    public function validate(): void
    {
        $this->request = $this->container->get('request_stack')->getCurrentRequest();

        $data = $this->request->request->all();

        $data = array_merge($data, $this->request->files->all());

        $constraint = [

            new Assert\Collection([

                'fields' => $this->getConstraint($data),

                'allowExtraFields' => true,

                'missingFieldsMessage' => 'Поле отсутствует'

            ])
        ];

        $validator = $this->container->get('validator');

        $violations = $validator->validate($data, $constraint);

        if (count($violations) !== 0) {

            $errors = [];

            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {

                try {

                    $propertyAccessor->setValue($errors, $violation->getPropertyPath(), $violation->getMessage());
                }
                catch (UnexpectedTypeException $exception) {

                    // skip
                }
            }

            throw new BusinessException('', 200, $errors);
        }
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->request->get($key, $default);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedServices(): array
    {
        return [
            'validator' => '?'.ValidatorInterface::class,
            'request_stack' => '?'.RequestStack::class,
        ];
    }

    /**
     * @required
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    abstract protected function getConstraint($data);
}