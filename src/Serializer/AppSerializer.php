<?php

namespace App\Serializer;

use App\Exception\BusinessException;
use App\Response\Resolver\CallbackResolver;
use App\Traits\ResponseStatusTrait;
use ArrayObject;
use Closure;
use DateTime;
use Doctrine\Common\Annotations\AnnotationReader;
use JetBrains\PhpStorm\NoReturn;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Service\Attribute\Required;

class AppSerializer
{
    /** @var Serializer $serializer */
    private Serializer $serializer;

    /**
     * @param CallbackResolver $callbackResolver
     */
    public function __construct(
        private readonly CallbackResolver $callbackResolver
    ){}

    #[Required]
    #[NoReturn]
    public function setSerializer(): void
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $context = [ AbstractNormalizer::CALLBACKS => $this->callbackResolver->getCallbacks() ];
        $normalizer = new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, null, null, null, $context);
        $this->serializer = new Serializer([$normalizer], ['json' => new JsonEncoder()]);
    }

    /**
     * @param mixed $data
     * @param array|string $groups
     * @param string $format
     * @return string
     */
    public function serialize(mixed $data, array|string $groups, string $format = 'json'): string
    {
        return $this->serializer->serialize($data, $format, ['groups' => $groups]);
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param array|string $groups
     * @param string $format
     * @return object
     */
    public function denormalize(mixed $data, string $type, array|string $groups, string $format = 'json'): object
    {
        try {
            return $this->serializer->denormalize($data, $type, $format, ['groups' => $groups]);
        } catch (ExceptionInterface $e) {
            return throw new BusinessException('Deserialization failed: ' . $e->getMessage(), 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * @param mixed $data
     * @param array|string $groups
     * @return array
     */
    public function normalize(mixed $data, array|string $groups): array
    {
        try {
            return $this->serializer->normalize($data, 'json', ['groups' => $groups]);
        } catch (ExceptionInterface $e) {
            return throw new BusinessException('Serialization failed: ' . $e->getMessage(), 500, ['error' => $e->getMessage()]);
        }
    }
}