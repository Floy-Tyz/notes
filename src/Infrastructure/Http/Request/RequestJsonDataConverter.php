<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Infrastructure\Http\Services\Serializer\ModelSerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

final class RequestJsonDataConverter implements ParamConverterInterface
{
    /**
     * @param ModelSerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private readonly ModelSerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ){}

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return is_subclass_of($configuration->getClass(), RequestJsonDataInterface::class);
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $dataClass = $configuration->getClass();

        $rawData = [
            ...$request->query->all(),
            ...$request->request->all()
        ];

        $constraints = $this->getClassConstraints($this->validator->getMetadataFor(new $dataClass()));

        $violations = $this->validator->validate(
            $rawData,
            new Collection([
                'allowExtraFields' => true,
                'fields' => $constraints,
            ])
        );

        if ($violations->count() > 0) {
            throw new ValidationFailedException('Ошибка валидации', $violations);
        }

        try {
            $data = $this->serializer->denormalize($rawData, $dataClass, null, [
                AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
            ]);
        } catch (Throwable $exception) {
            throw new BadRequestHttpException(
                $exception->getMessage(),
                $exception
            );
        }

        $request->attributes->set(
            $configuration->getName(),
            $data
        );

        return true;
    }

    /**
     * @param ClassMetadata $metadata
     * @return array
     */
    private function getClassConstraints(MetadataInterface $metadata): array
    {
        $constraints = [];

        foreach ($metadata->getConstrainedProperties() as $propertyName) {

            $propertyMetadataList = $metadata->getPropertyMetadata($propertyName);

            foreach ($propertyMetadataList as $propertyMetadataItem) {

                $constraints[$propertyName] = [ ...$constraints[$propertyName] ?? [], ...$propertyMetadataItem->getConstraints()];

            }
        }

        return $constraints;
    }
}
